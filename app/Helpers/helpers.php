<?php

function getJsonApi () {
    return json_encode([
        // Users
        'getUser' => route('get-auth-user'),
        'updatePassword' => route('update-user-password'),
        'getUsers' => route('get-users'),

        // Tasks
        'getTasks' => route('get-tasks'),
        'postTask' => route('post-task'),
        'postTaskUpdate' => route('post-task-update'),
        'deleteTaskUpdate' => route('delete-task-update'),

        // Clients
        'getClients' => route('get-clients'),
        'postClient' => route('post-client'),
        'deleteClient' => route('delete-client'),

        // Projects
        'postProject' => route('post-project'),
        'deleteProject' => route('delete-project'),

        // Others
        'getStatuses' => route('get-statuses'),
        'getPriorities' => route('get-priorities'),
    ]);
}