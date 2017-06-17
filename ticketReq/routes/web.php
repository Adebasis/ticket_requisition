<?php

// This is the Route page from where all request comes from View will be managed and
// Redirected to the Specific controller.
// once redirection taken place to specific controller, it searches for the Function associated with the
// Redirect request of the controller and process will be done.

Route::get('/maintenance/mode', 'AdminController@site_mode_page');

// vice-president
Route::get('/vp-approve','VPController@home_page');
Route::post('/vp-approve/requests','VPController@pending_request_page');
Route::get('/vp-approve/requests','VPController@pending_request_page');
Route::post('/vc_post_requests_multi_approved','VPController@vc_post_requests_multi_approved');

Route::get('/vp-approve/request/{id}/view/approver','VPController@RequestPageApprover');
Route::post('/Post_VP_RequestPageApprover','VPController@Post_VP_RequestPageApprover');

Route::get('/vp-approve/request/{id}/message/board','VPController@RequestPageMessageBoard');
Route::post('/Post_VP_RequestPageMessageBoard','VPController@Post_VP_RequestPageMessageBoard');

Route::post('/vp-approve/history','VPController@historypage');
Route::get('/vp-approve/history','VPController@historypage');

Route::post('/vp-approve/rejected-history','VPController@rejectedhistorypage');
Route::get('/vp-approve/rejected-history','VPController@rejectedhistorypage');

Route::get('/vp-approve/my-requests','VPController@myrequestpage');
Route::get('/vp-approve/game/{game_id}/view','VPController@myrequestentrypage');
Route::post('/post_VP_NewRequest','VPController@post_VP_NewRequest');
Route::get('/vp-approve/request/{id}/show/approver','VPController@RequestShowonly');
// vice-president


Route::get('/', 'HomeController@loginpage');
Route::post('/frontlogin','HomeController@postLogin');
Route::get('/frontlogin','HomeController@loginpage');

Route::get('/reset/password','HomeController@resetpasswordpage');
Route::post('/postResetPassword','HomeController@postResetPassword');
Route::get('/postResetPassword','HomeController@resetpasswordpage');

Route::get('/reset/password/{id}/link','HomeController@reset_password');
Route::post('/postResetPasswordSave','HomeController@postResetPasswordSave');


Route::get('/account/profile','HomeController@profilepage');
Route::get('/account/change-password','HomeController@changepasswordpage');
Route::get('/ChangePassword','HomeController@changepasswordpage');
Route::post('/ChangePassword','HomeController@ChangePassword');

Route::get('/logout','HomeController@logout');
Route::get('/default','HomeController@homepage');
Route::get('/about','HomeController@aboutpage');

Route::match(['get', 'post'], '/history','HomeController@historypage');
/*Route::get('/history','HomeController@historypage');
Route::post('/history','HomeController@historypage');*/
Route::post('/front_post_requests_multi_approved','HomeController@front_post_requests_multi_approved');
Route::post('/front_post_requests_multi_rejected','HomeController@front_post_requests_multi_rejected');
Route::post('/front_post_requests_multi_fulfiled','HomeController@front_post_requests_multi_fulfiled');

Route::get('/contact','HomeController@contactpage');

Route::get('/game/calender','HomeController@calenderpage');
Route::get('/game/{game_id}/view','HomeController@gameviewpage');

Route::get('/chart','HomeController@chartpage');

Route::get('/new/request','HomeController@calenderpage');
Route::post('/postNewRequest','HomeController@postNewRequest');
Route::get('/request/{id}/view/approver','HomeController@RequestPageApprover');
Route::get('/request/{id}/public/view','HomeController@RequestPageApprover');
Route::post('/Post_RequestPageApprover','HomeController@Post_RequestPageApprover');
Route::get('/history/request/{id}/message/board','ReqController@RequestPageMessageBoard');
Route::post('/Post_RequestPageMessageBoard','ReqController@Post_RequestPageMessageBoard');
Route::post('/RequestPageMessageBoard_loadmore','ReqController@RequestPageMessageBoard_loadmore');



//adminpanel
Route::get('/adminpanel', 'AdminController@loginpage');
Route::post('/postlogin','AdminController@postLogin');
Route::get('/adminpanel/logout','AdminController@logout');

Route::get('/adminpanel/reset/password','AdminController@resetpasswordpage');
Route::post('/adminpostResetPassword','AdminController@postResetPassword');
Route::get('/adminpostResetPassword','AdminController@resetpasswordpage');

Route::get('/adminpanel/reset/password/{id}/link','AdminController@reset_password');
Route::post('/adminpostResetPasswordSave','AdminController@adminpostResetPasswordSave');

Route::get('/adminpanel/home','AdminController@homepage');

Route::get('/adminpanel/profile','AdminController@profilepage');
Route::post('/adminupdateProfile','AdminController@adminupdateProfile');

Route::get('/adminpanel/change-password','AdminController@changepasswordpage');
Route::post('/adminChangePassword','AdminController@adminChangePassword');

Route::get('/adminpanel/settings','AdminController@settings_page');
Route::post('/admin_post_settings','AdminController@admin_post_settings');

Route::get('/adminpanel/departments','AdminController@departmentspage');
Route::get('/adminpanel/departments/entry','AdminController@departments_entry_page');
Route::post('/admindepartmententry','AdminController@admindepartmententry');
Route::get('/adminpanel/departments/{id}/edit','AdminController@departments_edit_page');
Route::post('/admindepartmentedit','AdminController@admindepartmentedit');
Route::get('/adminpanel/departments/{id}/approver','AdminController@departments_approver_page');
Route::post('/admin_post_department_approver','AdminController@admin_post_department_approver');
Route::get('/adminpanel/departments/{id}/delete','AdminController@admindepartmentdelete');

Route::get('/adminpanel/roles','AdminController@rolespage');
Route::get('/adminpanel/roles/entry','AdminController@roles_entry_page');
Route::post('/adminRolesEntry','AdminController@adminRolesEntry');
Route::get('/adminpanel/roles/{id}/edit','AdminController@roles_edit_page');
Route::post('/adminRolesEdit','AdminController@adminRolesEdit');
Route::get('/adminpanel/roles/{id}/delete','AdminController@adminRolesDelete');
Route::get('/adminpanel/roles/{id}/tasks/assign','AdminController@roles_tasks_assign_page');
Route::post('/admin_post_roles_tasks_assign_page','AdminController@admin_post_roles_tasks_assign_page');

Route::get('/adminpanel/tasks','AdminController@taskspage');
Route::get('/adminpanel/tasks/entry','AdminController@tasks_entry_page');
Route::post('/adminTasksEntry','AdminController@adminTasksEntry');
Route::get('/adminpanel/tasks/{id}/edit','AdminController@tasks_edit_page');
Route::post('/adminTasksEdit','AdminController@adminTasksEdit');
Route::get('/adminpanel/tasks/{id}/delete','AdminController@adminTasksDelete');

Route::get('/adminpanel/gamestate','AdminController@gamestatepage');
Route::get('/adminpanel/gamestate/entry','AdminController@gamestate_entry_page');
Route::post('/adminGamestateEntry','AdminController@adminGamestateEntry');
Route::get('/adminpanel/gamestate/{id}/edit','AdminController@gamestate_edit_page');
Route::post('/adminGamestateEdit','AdminController@adminGamestateEdit');
Route::get('/adminpanel/gamestate/{id}/delete','AdminController@adminGamestateDelete');

Route::get('/adminpanel/employeetype','AdminController@employeetypepage');
Route::get('/adminpanel/employeetype/entry','AdminController@employeetype_entry_page');
Route::post('/adminEmployeeTypeEntry','AdminController@adminEmployeeTypeEntry');
Route::get('/adminpanel/employeetype/{id}/edit','AdminController@employeetype_edit_page');
Route::post('/adminEmployeeTypeEdit','AdminController@adminEmployeeTypeEdit');
Route::get('/adminpanel/employeetype/{id}/delete','AdminController@adminEmployeeTypeDelete');

Route::get('/adminpanel/deliverytype','AdminController@deliverytypepage');
Route::get('/adminpanel/deliverytype/entry','AdminController@deliverytype_entry_page');
Route::post('/admindeliverytypeentry','AdminController@admindeliverytypeentry');
Route::get('/adminpanel/deliverytype/{id}/edit','AdminController@deliverytype_edit_page');
Route::post('/admindeliverytypeedit','AdminController@admindeliverytypeedit');
Route::get('/adminpanel/deliverytype/{id}/delete','AdminController@admindeliverytypedelete');

Route::get('/adminpanel/demandtype','AdminController@demandtypepage');
Route::get('/adminpanel/demandtype/entry','AdminController@demandtype_entry_page');
Route::post('/admindemandtypeentry','AdminController@admindemandtypeentry');
Route::get('/adminpanel/demandtype/{id}/edit','AdminController@demandtype_edit_page');
Route::post('/admindemandtypeedit','AdminController@admindemandtypeedit');
Route::get('/adminpanel/demandtype/{id}/delete','AdminController@admindemandtypedelete');

Route::get('/adminpanel/locationtype','AdminController@locationtypepage');
Route::get('/adminpanel/locationtype/entry','AdminController@locationtype_entry_page');
Route::post('/adminlocationtypeentry','AdminController@adminlocationtypeentry');
Route::get('/adminpanel/locationtype/{id}/edit','AdminController@locationtype_edit_page');
Route::post('/adminlocationtypeedit','AdminController@adminlocationtypeedit');
Route::get('/adminpanel/locationtype/{id}/delete','AdminController@adminlocationtypedelete');

Route::get('/adminpanel/gamerequeststate','AdminController@gamerequeststatepage');
Route::get('/adminpanel/gamerequeststate/entry','AdminController@gamerequeststate_entry_page');
Route::post('/admingamerequeststateentry','AdminController@admingamerequeststateentry');
Route::get('/adminpanel/gamerequeststate/{id}/edit','AdminController@gamerequeststate_edit_page');
Route::post('/admingamerequeststateedit','AdminController@admingamerequeststateedit');
Route::get('/adminpanel/gamerequeststate/{id}/delete','AdminController@admingamerequeststatedelete');

Route::get('/adminpanel/useraccount','AdminController@useraccountpage');
Route::get('/adminpanel/api/useraccount','AdminController@useraccountpage_list');
Route::get('/adminpanel/useraccount/entry','AdminController@admin_useraccount_entry_page');
Route::post('/admin_post_useraccount_entry','AdminController@admin_post_useraccount_entry');
Route::get('/adminpanel/useraccount/{id}/edit','AdminController@admin_useraccount_edit_page');
Route::post('/admin_post_useraccount_edit','AdminController@admin_post_useraccount_edit');
Route::get('/adminpanel/useraccount/{id}/setpassword','AdminController@admin_useraccount_setpassword_page');
Route::post('/admin_post_useraccount_setpassword','AdminController@admin_post_useraccount_setpassword');
Route::get('/adminpanel/useraccount/{id}/delete','AdminController@admin_useraccount_delete');
Route::get('/admin_post_users_multi_delete','AdminController@useraccountpage');
Route::post('/admin_post_users_multi_delete','AdminController@admin_post_users_multi_delete');
Route::get('/adminpanel/useraccount/{user_id}/assign-reports','AdminController@admin_useraccount_assign_reports_page');
Route::post('/admin_post_users_assign_reports','AdminController@admin_post_users_assign_reports');

Route::get('/adminpanel/subadmin','AdminController@subadminpage');
Route::get('/adminpanel/subadmin/entry','AdminController@admin_subadmin_entry_page');
Route::post('/admin_post_subadmin_entry','AdminController@admin_post_subadmin_entry');
Route::get('/adminpanel/subadmin/{id}/edit','AdminController@admin_subadmin_edit_page');
Route::post('/admin_post_subadmin_edit','AdminController@admin_post_subadmin_edit');
Route::get('/adminpanel/subadmin/{id}/delete','AdminController@admin_subadmin_delete');
Route::post('/admin_post_subadmin_profile_edit','AdminController@admin_post_subadmin_profile_edit');

Route::get('/adminpanel/requests','AdminController@RequestPage');
Route::post('/adminpanel/requests','AdminController@RequestPage');
Route::get('/adminpanel/requests/{id}/view/edit','AdminController@RequestPageEdit');

Route::get('/adminpanel/requests/{id}/message/board','AdminController@RequestPageMessageBoard');
Route::post('/adminPost_RequestPageMessageBoard','AdminController@adminPost_RequestPageMessageBoard');
Route::post('/adminRequestPageMessageBoard_loadmore','AdminController@adminRequestPageMessageBoard_loadmore');

Route::post('/admin_post_requests_multi_approved','AdminController@admin_post_requests_multi_approved');

Route::get('/adminpanel/game','AdminController@gamepage');
Route::get('/adminpanel/game/entry','AdminController@admin_game_entry_page');
Route::post('/admin_post_game_entry','AdminController@admin_post_game_entry');
Route::get('/admin_post_game_entry','AdminController@gamepage');
Route::get('/adminpanel/game/{id}/edit','AdminController@admin_game_edit_page');
Route::post('/admin_post_game_edit','AdminController@admin_post_game_edit');
Route::get('/admin_post_game_edit','AdminController@gamepage');
Route::get('/adminpanel/game/{id}/delete','AdminController@admin_game_delete');

Route::get('/adminpanel/siteresourcetype','AdminController@siteresourcetypepage');
Route::get('/adminpanel/siteresourcetype/entry','AdminController@admin_siteresourcetype_entry_page');
Route::post('/admin_post_siteresourcetype_entry','AdminController@admin_post_siteresourcetype_entry');
Route::get('/adminpanel/siteresourcetype/{id}/edit','AdminController@admin_siteresourcetype_edit_page');
Route::post('/admin_post_siteresourcetype_edit','AdminController@admin_post_siteresourcetype_edit');
Route::get('/adminpanel/siteresourcetype/{id}/delete','AdminController@admin_siteresourcetype_delete');

Route::get('/adminpanel/ticketsourcetype','AdminController@ticketsourcetypepage');
Route::get('/adminpanel/ticketsourcetype/entry','AdminController@admin_ticketsourcetype_entry_page');
Route::post('/admin_post_ticketsourcetype_entry','AdminController@admin_post_ticketsourcetype_entry');
Route::get('/adminpanel/ticketsourcetype/{id}/edit','AdminController@admin_ticketsourcetype_edit_page');
Route::post('/admin_post_ticketsourcetype_edit','AdminController@admin_post_ticketsourcetype_edit');
Route::get('/adminpanel/ticketsourcetype/{id}/delete','AdminController@admin_ticketsourcetype_delete');

Route::get('/adminpanel/promotion','AdminController@promotionpage');
Route::get('/adminpanel/promotion/entry','AdminController@admin_promotion_entry_page');
Route::post('/admin_post_promotion_entry','AdminController@admin_post_promotion_entry');
Route::get('/adminpanel/promotion/{id}/edit','AdminController@admin_promotion_edit_page');
Route::post('/admin_post_promotion_edit','AdminController@admin_post_promotion_edit');
Route::get('/adminpanel/promotion/{id}/delete','AdminController@admin_promotion_delete');

Route::get('/adminpanel/emailtemplate','AdminController@emailtemplatepage');
Route::get('/adminpanel/emailtemplate/{id}/edit','AdminController@admin_emailtemplate_edit_page');
Route::post('/admin_post_emailtemplate_edit','AdminController@admin_post_emailtemplate_edit');

Route::get('/adminpanel/events/logs','AdminController@logspage');
Route::post('/admin_post_logs_load_more_page','AdminController@admin_post_logs_load_more_page');

Route::get('/adminpanel/teams','TeamController@teamspage');
Route::get('/adminpanel/teams/entry','TeamController@admin_teams_entry_page');
Route::post('/admin_post_team_entry','TeamController@admin_post_team_entry');
Route::get('/adminpanel/teams/{id}/edit','TeamController@admin_teams_edit_page');
Route::post('/admin_post_team_edit','TeamController@admin_post_team_edit');
Route::get('/adminpanel/teams/{id}/delete','TeamController@admin_teams_delete');

Route::get('/adminpanel/allocationpooltype','TeamController@allocationpooltypepage');
Route::get('/adminpanel/allocationpooltype/entry','TeamController@admin_allocationpooltype_entry_page');
Route::post('/admin_post_allocationpooltype_entry','TeamController@admin_post_allocationpooltype_entry');
Route::get('/adminpanel/allocationpooltype/{id}/edit','TeamController@admin_allocationpooltype_edit_page');
Route::post('/admin_post_allocationpooltype_edit','TeamController@admin_post_allocationpooltype_edit');
Route::get('/adminpanel/allocationpooltype/{id}/delete','TeamController@admin_allocationpooltype_delete');

Route::get('/adminpanel/deliverygroup','TeamController@deliverygrouppage');
Route::get('/adminpanel/deliverygroup/entry','TeamController@admin_deliverygroup_entry_page');
Route::post('/admin_post_deliverygroup_entry','TeamController@admin_post_deliverygroup_entry');
Route::get('/adminpanel/deliverygroup/{id}/edit','TeamController@admin_deliverygroup_edit_page');
Route::post('/admin_post_deliverygroup_edit','TeamController@admin_post_deliverygroup_edit');
Route::get('/adminpanel/deliverygroup/{id}/delete','TeamController@admin_deliverygroup_delete');

Route::get('/adminpanel/approvalrequirementtype','TeamController@approvalrequirementtypepage');
Route::get('/adminpanel/approvalrequirementtype/entry','TeamController@admin_approvalrequirementtype_entry_page');
Route::post('/admin_post_approvalrequirementtype_entry','TeamController@admin_post_approvalrequirementtype_entry');
Route::get('/adminpanel/approvalrequirementtype/{id}/edit','TeamController@admin_approvalrequirementtype_edit_page');
Route::post('/admin_post_approvalrequirementtype_edit','TeamController@admin_post_approvalrequirementtype_edit');
Route::get('/adminpanel/approvalrequirementtype/{id}/delete','TeamController@admin_approvalrequirementtype_delete');

Route::get('/adminpanel/pricingtype','TeamController@pricingtypepage');
Route::get('/adminpanel/pricingtype/entry','TeamController@admin_pricingtype_entry_page');
Route::post('/admin_post_pricingtype_entry','TeamController@admin_post_pricingtype_entry');
Route::get('/adminpanel/pricingtype/{id}/edit','TeamController@admin_pricingtype_edit_page');
Route::post('/admin_post_pricingtype_edit','TeamController@admin_post_pricingtype_edit');
Route::get('/adminpanel/pricingtype/{id}/delete','TeamController@admin_pricingtype_delete');

Route::get('/adminpanel/fully-approved-requests','AdminController@requests_fully_approved_page');

Route::get('/adminpanel/test','TeamController@test_page');

Route::get('/adminpanel/test-mail','MailController@test_mail');
Route::post('/adminpanel/admin_post_mail_testings','MailController@admin_post_mail_testings');
Route::post('/adminpanel/admin_post_mail_testings_internal','MailController@admin_post_mail_testings_internal');

Route::get('/adminpanel/apps-settings','AdminController@admin_appsettings');
Route::post('/adminpanel/admin_post_appsettings','AdminController@admin_post_appsettings');

Route::get('/adminpanel/database/backup','BackupController@admin_backuppage');
Route::post('/adminpanel/admin_post_backuppage','BackupController@admin_post_backuppage');

Route::get('/adminpanel/download-event-logs','AdminController@admin_download_logs');

Route::get('/adminpanel/reports/requested/users','AdminController@admin_reports_requested_by_users');
Route::post('/admin_post_reports_requested_users_download','AdminController@admin_post_reports_requested_users_download');
Route::get('/adminpanel/reports/requested/games','AdminController@admin_reports_requested_by_games');
Route::post('/admin_post_reports_requested_games_download','AdminController@admin_post_reports_requested_games_download');
Route::get('/adminpanel/reports/requested/teams','AdminController@admin_reports_requested_by_teams');
Route::post('/admin_post_reports_requested_teams_download','AdminController@admin_post_reports_requested_teams_download');
Route::get('/adminpanel/reports/fulfilled/date','AdminController@admin_reports_fulfilled_by_date');
Route::post('/admin_post_reports_fulfilled_date_download','AdminController@admin_post_reports_fulfilled_date_download');
Route::get('/adminpanel/reports/fulfilled/games','AdminController@admin_reports_fulfilled_by_games');
Route::post('/admin_post_reports_fulfilled_games_download','AdminController@admin_post_reports_fulfilled_games_download');
Route::get('/admin_post_error_logs','AdminController@admin_post_error_logs');
Route::get('/adminpanel/errors/logs','AdminController@admin_get_error_logs_page');
Route::post('/admin_post_error_logs_multi_delete','AdminController@admin_post_error_logs_multi_delete');

Route::get('/adminpanel/error','AdminController@admin_get_error_page');

Route::get('/adminpanel/500_customize_error','AdminController@admin_500_customize_page');
Route::post('/edit_customize_error','AdminController@edit_customize_error');

Route::get('/adminpanel/customize_maintenance_message','AdminController@admin_maintenance_message_page');
Route::post('/admin_post_maintenance_message','AdminController@admin_post_maintenance_message');

Route::get('/adminpanel/send-reminder-emails','ReminderController@remind_send_remider_emails_page');
Route::post('/remind_post_send_remider_emails_page','ReminderController@remind_post_send_remider_emails_page');
Route::get('/adminpanel/send-reminder-emails','ReminderController@remind_send_remider_emails_page');
Route::get('/adminpanel/send-reminder-emails/{id}/delete','ReminderController@remind_send_remider_delete');