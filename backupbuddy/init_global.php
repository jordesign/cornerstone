<?php // This code runs everywhere.

// Make localization happen.
load_plugin_textdomain( 'it-l10n-backupbuddy', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );



/********** ACTIONS (global) **********/
pb_backupbuddy::add_action( array( 'pb_backupbuddy-cron_scheduled_backup', 'process_scheduled_backup' ), 10, 5 ); // Scheduled backup.



/********** AJAX (global) **********/



/********** CRON (global) **********/
pb_backupbuddy::add_cron( 'process_backup', 10, 1 ); // Normal (manual) backup. Normal backups use cron system for scheduling each step when in modern mode. Classic mode skips this and runs all in one PHP process.
pb_backupbuddy::add_cron( 'final_cleanup', 10, 1 ); // Cleanup after backup.
pb_backupbuddy::add_cron( 'remote_send', 10, 4 ); // Manual remote destination sending.
pb_backupbuddy::add_cron( 'destination_send', 10, 2 ); // Manual remote destination sending.

// Remote destination copying. Eventually combine into one function to pass to individual remote destination classes to process.
pb_backupbuddy::add_cron( 'process_s3_copy', 10, 5 );
pb_backupbuddy::add_cron( 'process_remote_copy', 10, 3 );
pb_backupbuddy::add_cron( 'process_dropbox_copy', 10, 2 );
pb_backupbuddy::add_cron( 'process_rackspace_copy', 10, 5 );
pb_backupbuddy::add_cron( 'process_ftp_copy', 10, 5 );



/********** FILTERS (global) **********/
pb_backupbuddy::add_filter( 'cron_schedules', 10, 0 ); // Add schedule periods such as bimonthly, etc into cron.



/********** WIDGETS (global) **********/

?>