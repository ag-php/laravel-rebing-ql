<?php

declare(strict_types=1);

/**
 * To encode data to send in the URL or JSON
 * php version 7.2.10.
 *
 * @category Translations
 * @author   Albert <abarrientos@inspiracion.cl>
 * @license  no LICENSE
 * @link     http://www.inspiracion.cl
 */

return [
    'error500' => "The application has encountered an unknown error. It doesn't appear to have affected your data, but our technical staff have been automatically notified and will be looking into this with the utmost urgency.",
    'project_no_authorized' => 'Project does not exist or you are not authorized to use it (error code: :idCompany-:idProject).',
    'device_no_authorized' => 'Device does not exist or you are not authorized to use it (error code: :idCompany-:device_id).',
    'tag_no_authorized' => 'Tag does not exist or you are not authorized to use it (error code: :idCompany-:tag_id).',
    'user_not_found' => 'User was not found (error code: :user_id).',
    'user_equals_status' => 'User already has the status (error code: :user_id-:status).',
    'project_no_images' => 'You project have not images',
    'project_no_device_type' => 'The devices :type does not exist in the project',
    'you_cannot_delete_it' => 'The current element is already in use, you cannot to delete it. Detail: :detail',
    'unique_error' => 'The value inserted must be unique. Detail: :detail',
    'item_not_found' => 'The item :item was not found',
    'deleted_success' => 'The item :item was deleted successfully',
    'created_success' => 'The item :item was created successfully',
    'saved_success' => 'The items was saved successfully',
    'saved_success_items' => 'The items were saved successfully',
    'updated_success' => 'The item :item was updated successfully',
    'item_blocked' => 'Sorry, the item you are trying to update or delete is blocked.',
    'blocked_no_right' => 'Sorry, you dont have the right to unblocked this item.',
    'blocked_update' => 'You updated a blocked learning object.',
    'blocked_deleted' => 'You deleted a blocked item.',
    'C0002' => "The value doesn't exists. Detail: :detail",
];
