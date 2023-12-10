<?php

namespace Leantime\Domain\Clients\Services;

use Leantime\Core\Service;
use Leantime\Core\Template as TemplateCore;
use Leantime\Core\Eventhelpers;
use Leantime\Core\Template;
use Leantime\Domain\Projects\Repositories\Projects as ProjectRepository;
use Leantime\Domain\Clients\Repositories\Clients as ClientRepository;
use Leantime\Domain\Projects\Repositories\Projects;

/**
 *
 */
class Clients implements Service
{
    private ProjectRepository $projectRepository;
    private ClientRepository $clientRepository;

    /**
     * @param TemplateCore      $tpl
     * @param ProjectRepository $projectRepository
     * @param ClientRepository  $clientRepository
     */
    public function __construct(
        ProjectRepository $projectRepository,
        ClientRepository $clientRepository,
    ) {
        $this->projectRepository = $projectRepository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getUserClients(int $userId): array
    {
        $userProjects = $this->projectRepository->getUserProjects($userId);
        $clients = [];

        if (is_array($userProjects)) {
            $userClients = [];
            foreach ($userProjects as $project) {
                if (!array_key_exists($project["clientId"], $clients)) {
                    $clients[$project["clientId"]] = array("id" => $project["clientId"], "name" => $project['clientName']);
                }
            }
        }

        return $clients;
    }

    /**
     * @return array
     */
    public function getAll(array $searchparams = null): array
    {
        return $this->clientRepository->getAll();
    }

    /**
     * patches the client by key.
     *
     * @param int   $id     Id of the object to be patched
     * @param  array $params Key=>value array where key represents the object field name and value the value.
     * @access public
     *
     * @return bool returns true on success, false on failure
     */
    public function patch(int $id, array $params): bool
    {
        return $this->clientRepository->patch($id, $params);
    }

    /**
     * updates the client by key.
     *
     * @param  object|array $object expects the entire object to be updated as object or array
     * @access public
     *
     * @return bool                 Returns true on success, false on failure
     */
    public function editClient(object|array $object): bool
    {
        return $this->clientRepository->editClient($object, $object['id']);
    }

    /**
     * Creates a new client
     *
     * @access public
     * @param  object|array $object Object or array to be created
     * @return int|false                Returns id of new element or false
     */
    public function create(object|array $object): int|false
    {
        return $this->clientRepository->addClient($object);
    }

    /**
     * Deletes a client
     *
     * @access public
     * @param int $id Id of the object to be deleted
     * @return bool     Returns id of new element or false
     */
    public function delete(int $id): bool
    {
        return $this->clientRepository->deleteClient($id);
    }

    /**
     * Gets 1 specific client by id
     *
     * @access public
     * @param int $id Id of the object to be retrieved
     * @return object|array|false Returns object or array. False on failure or if item cannot be found
     */
    public function get(int $id): object|array|false
    {
        return $this->clientRepository->getClient($id);
    }
}
