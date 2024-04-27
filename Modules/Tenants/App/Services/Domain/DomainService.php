<?php

namespace Modules\Tenants\App\Services\Domain;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Tenants\App\Contracts\CrudMicroService;
use Modules\Tenants\App\Enums\Domain\DomainServiceError;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Tenant\Domains;

class DomainService implements CrudMicroService
{
    /**
     * Find a domain by its ID.
     *
     * @param int $domainId The ID of the domain to find.
     * @return Domains|null Returns the domain if found, or null if not found.
     * @throws ServiceException if the domain cannot be found.
     */
    public function find(int $domainId): ?Domains
    {
        $domain = Domains::findOrFail($domainId);
        if (!$domain) {
            throw new ServiceException(
                DomainServiceError::NotFoundOrUpdateError->value,
                $domain
            );
        }
        // Additional logic can be added here if necessary
        return $domain;
    }

    /**
     * List all domains with optional filtering.
     *
     * @param array $data Criteria for filtering the list of domains.
     * @return mixed A paginated list of domains based on the provided criteria.
     * @example if perPage = -1 return all rows without pagination
     */
    public function list(array $data, bool $isPaginate = true)
    {
        $query = Domains::where(function ($query) use ($data) {
            // Apply a LIKE filter if the 'domain' key is set and not empty
            if (!empty($data['domain']['domain'])) {
                $query->where('domain', 'LIKE', '%' . $data['domain']['domain'] . '%');
            }
        });

        // Set a default value for 'perPage'. If 'perPage' is -1, return all records
        $perPage = $data['perPage'] ?? 10;

        // If 'perPage' is -1 or pagination is disabled, return all records
        if ($perPage === -1 || !$isPaginate) {
            return $query->get();
        }

        // Apply pagination with specified or default values
        return $query->paginate($perPage, '*', 'page', $data['page'] ?? 1);
    }


    /**
     * Create a new domain.
     *
     * @param array $data Data required to create the domain.
     * @return Domains|null The newly created domain object.
     * @throws ServiceException if there's an error in creating the domain.
     */
    public function create(array $data): ?Domains
    {
        if ($this->isValidData($data)) {
            $existingDomain = Domains::where('domain', $data['domain']['domain'])->first();
            if ($existingDomain) {
                throw new ServiceException(
                    DomainServiceError::DomainErrorDuplicate->value,
                    $data
                );
            }
            $data['domain']['tenant_id'] = Str::slug($data['domain']['domain'], '');
            $domain = Domains::firstOrNew(
                ['domain' => $data['domain']['domain']],
                $data['domain']
            );

            if ($domain->exists) {
                throw new ServiceException(
                    DomainServiceError::DomainAlreadyExists->value,
                    $data
                );
            } else {
                $domain->save();
                return $domain;
            }
        } else {
            throw new ServiceException(
                DomainServiceError::CreationError->value,
                $data
            );
        }
    }

    /**
     * Update an existing domain.
     *
     * @param array $data Data required to update the domain.
     * @return Domains The updated domain object.
     * @throws ServiceException if there's an error in updating the domain.
     */
    public function update(array $data)
    {
        if ($this->isValidData($data) && isset($data['domain']['domain_id'])) {
            $existingDomain = Domains::where('domain', $data['domain']['domain'])
                ->where('id', '!=', $data['domain']['domain_id'])->first();
            if ($existingDomain) {
                throw new ServiceException(
                    DomainServiceError::DomainErrorDuplicate->value,
                    $data
                );
            }
            $domain = Domains::find($data['domain']['domain_id']);
            if ($domain) {
                DB::transaction(function () use ($domain, $data) {
                    if ($domain->update(['domain' => $data['domain']['domain']])) {
                        return $domain;
                    } else {
                        throw new ServiceException(
                            DomainServiceError::UpdateFailed->value,
                            $data
                        );
                    }
                });
            } else {
                throw new ServiceException(
                    DomainServiceError::DomainNotFound->value,
                    $data
                );
            }
        } else {
            throw new ServiceException(
                DomainServiceError::NotFoundOrUpdateError->value,
                $data
            );
        }
    }

    /**
     * Delete a domain.
     *
     * @param array $data
     * @throws ServiceException if the domain cannot be deleted.
     */
    public function delete(array $data): bool
    {
        if (isset($data['domain']['domain_id'])) {
            $domain = Domains::find($data['domain']['domain_id']);
            if ($domain) {
                DB::transaction(function () use ($domain) {
                    $domain->delete();
                });
                return true;
            } else {
                throw new ServiceException(
                    DomainServiceError::NotFoundForDeletion->value,
                    $data
                );
            }
        }
        return false;
    }

    /**
     * Delete multiple domains by their IDs.
     *
     * @param array $data Array containing 'domain_ids' as a comma-separated string.
     * @throws ServiceException if the deletion fails.
     */
    public function deleteAll(array $data)
    {
        if (isset($data['domain']['domain_ids'])) {
            $data['domain']['domain_ids'] = explode(',', $data['domain']['domain_ids']);
            if (is_array($data['domain']['domain_ids'])) {
                foreach ($data['domain']['domain_ids'] as $domainId) {
                    $domain = Domains::find($domainId);
                    if ($domain) {
                        DB::transaction(function () use ($domain) {
                            $domain->delete();
                        });
                    } else {
                        throw new ServiceException(
                            DomainServiceError::NotFoundForDeletion->value,
                            $data
                        );
                    }
                }
            } else {
                throw new ServiceException(
                    DomainServiceError::DeleteAllError->value,
                    $data
                );
            }
        } else {
            throw new ServiceException(
                DomainServiceError::DeletionError->value,
                $data
            );
        }
    }

    /**
     * Checks if the data is valid.
     *
     * @param array $data The data to be checked.
     * @return bool Returns true if the data is valid, false otherwise.
     */
    private function isValidData(array $data): bool
    {
        return !empty($data['domain']) && !empty($data['domain']['domain']);
    }
}
