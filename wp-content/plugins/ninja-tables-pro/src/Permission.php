<?php

namespace NinjaTablesPro;

class Permission
{
    /**
     * Get the permission from the options table.
     */
    public static function get()
    {
        wp_send_json([
            'capability' => get_option('_ninja_tables_permission')
        ], 200);
    }

    /**
     * Set the permission to the options table.
     */
    public static function set()
    {
        $capability = sanitize_text_field($_REQUEST['capability']);
        update_option('_ninja_tables_permission', $capability, true);
        wp_send_json([
            'message' => __('Successfully selected the role(s).', 'ninja-tables')
        ], 200);
    }
    
    public static function modifyPermission($permission)
    {
	    $newPermission = get_option('_ninja_tables_permission', $permission);
	    return $newPermission;
    }
}
