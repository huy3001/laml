<?php

namespace NinjaTablesPro;

class Position
{
    /**
     * Make position value of the table item.
     *
     * @param  array $attributes
     * @return array $attributes
     */
    public static function make($attributes)
    {
        $tableId = $attributes['table_id'];

        // If position is provided from the client then it is safe
	    // to assume that the data is migrated for the table
        if (isset($_REQUEST['position'])) {
            $position = $_REQUEST['position'];

            if ($position === 'first') {
                $attributes['position'] = 1;

                static::increment($tableId);
            } elseif ($position === 'last') {
                $attributes['position'] = ninja_tables_DbTable()->where('table_id', $tableId)->count() + 1;
            } else {
                $attributes['position'] = $position;

                static::increment($tableId, $position);
            }
        } else {
        	// Otherwise, we need to determine manually that the table data is migrated or not.
	        $dataMigrated = ninjaTablesDataMigratedForManualSort($tableId);
	        
	        // If migrated we'll determine the position accordingly.
	        if ($dataMigrated) {
		        $attributes['position'] = ninja_tables_DbTable()->where('table_id', $tableId)->count() + 1;
	        }
        }

        return $attributes;
    }

    /**
     * Increment the table items based on constraints.
     *
     * @param int  $tableId
     * @param null $position
     */
    public static function increment($tableId, $position = null)
    {
        global $wpdb;

        $tableName = $wpdb->prefix.ninja_tables_db_table_name();

        $query = "UPDATE {$tableName}
                  SET position = position + 1
                  WHERE table_id = %d";

        $bindings = [
            $tableId
        ];

        if ($position) {
            $query .= " AND position >= %d ";

            $bindings[] = $position;
        }

        $query .= "ORDER BY position DESC";

        $wpdb->query($wpdb->prepare($query, $bindings));
    }
}
