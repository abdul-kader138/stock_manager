<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Module: General Language File for common lang keys
 * Language: English
 *
 * Last edited:
 * 15th August 2015
 *
 * Package:
 * Simple Stock Manage v2.0
 *
 * You can translate this file to your language.
 * For instruction on new language setup, please visit the documentations.
 * You also can share your language files by emailing to saleem@tecdiary.com
 * Thank you
 */

/* ----------------------- CUSTOM FILEDS ----------------------- */
$lang['ccf1']                               = "Customer Custom Field 1";
$lang['ccf2']                               = "Customer Custom Field 2";
$lang['scf1']                               = "Supplier Custom Field 1";
$lang['scf2']                               = "Supplier Custom Field 2";

/* ----------------- DATATABLES LANGUAGE ---------------------- */
/*
* Below are datatables language entries
* Please only change the part after = and make sure you change the the words in between "";
* 'sEmptyTable'                     => "No data available in table",
* Don't change this                 => "You can change this part but not the word between and ending with _ like _START_;
* For support email support@tecdiary.com Thank you!
*/

$lang['datatables_lang']        = array(
    'sEmptyTable'                   => "No data available in table",
    'sInfo'                         => "Showing _START_ to _END_ of _TOTAL_ entries",
    'sInfoEmpty'                    => "Showing 0 to 0 of 0 entries",
    'sInfoFiltered'                 => "(filtered from _MAX_ total entries)",
    'sInfoPostFix'                  => "",
    'sInfoThousands'                => ",",
    'sLengthMenu'                   => "Show _MENU_ ",
    'sLoadingRecords'               => "Loading...",
    'sProcessing'                   => "Processing...",
    'sSearch'                       => "Search",
    'sZeroRecords'                  => "No matching records found",
    'oAria'                         => array(
        'sSortAscending'            => ": activate to sort column ascending",
        'sSortDescending'           => ": activate to sort column descending"
        ),
    'oPaginate'                     => array(
        'sFirst'                    => "<i class=\"fa fa-angle-double-left\"></i>",
        'sLast'                     => "<i class=\"fa fa-angle-double-right\"></i>",
        'sNext'                     => "<i class=\"fa fa-angle-right\"></i>",
        'sPrevious'                 => "<i class=\"fa fa-angle-left\"></i>",
        )
    );

/* ----------------- Select2 LANGUAGE ---------------------- */
/*
* Below are select2 lib language entries
* Please only change the part after = and make sure you change the the words in between "";
* 's2_errorLoading'                 => "The results could not be loaded",
* Don't change this                 => "You can change this part but not the word between {} like {t};
* For support email support@tecdiary.com Thank you!
*/

$lang['select2_lang']               = array(
    'formatMatches_s'               => "One result is available, press enter to select it.",
    'formatMatches_p'               => "results are available, use up and down arrow keys to navigate.",
    'formatNoMatches'               => "No matches found",
    'formatInputTooShort'           => "Please type {n} or more characters",
    'formatInputTooLong_s'          => "Please delete {n} character",
    'formatInputTooLong_p'          => "Please delete {n} characters",
    'formatSelectionTooBig_s'       => "You can only select {n} item",
    'formatSelectionTooBig_p'       => "You can only select {n} items",
    'formatLoadMore'                => "Loading more results...",
    'formatAjaxError'               => "Ajax request failed",
    'formatSearching'               => "Searching..."
    );


/* ----------------- GENERAL LANGUAGE KEYS -------------------- */
$lang['dashboard']                            = "اللوحة الرئيسية";
$lang['items']                                = "المواد";
$lang['list_items']                           = "قائمة المواد";
$lang['add_item']                             = "إضافة مادة";
$lang['import_items']                         = "رفع المواد";
$lang['print_barcodes']                       = "طباعة الباركود";
$lang['print_labels']                         = "طباعى اللصاقات";
$lang['check_ins']                            = "الإدخالات";
$lang['list_check_ins']                       = "عرض الإدخالات";
$lang['new_check_in']                         = "إدخال جديد";
$lang['check_in_by_csv']                      = "ادخال من ملف";
$lang['check_outs']                           = "الإخراجات";
$lang['list_check_outs']                      = " عرض الإخراجات ";
$lang['new_check_out']                        = "إخراج جديد";
$lang['check_out_by_csv']                     = "إخراج من ملف";
$lang['users']                                = "المستخدمين";
$lang['list_users']                           = "قائمة المستخدمين";
$lang['add_user']                             = "اضافة مستخدم";
$lang['settings']                             = "الإعدادات";
$lang['categories']                           = "الأصناف";
$lang['add_category']                         = "إضافة صنف جديد";
$lang['import_categories']                    = "رفع التصنيفات";
$lang['backups']                              = "النسخ الاحتياطي";
$lang['updates']                              = "التحديث";
$lang['profile']                              = "الملف الشخصي";
$lang['logout']                               = "الخروج";
$lang['no_of_check_ins_and_outs']             = "عدد الادخالات والاخراجات";
$lang['welcome']                              = "اهلا بك في";
$lang['dashboard_heading']                    = "عرض بياني لجميع الادخالات والاخراجات";
$lang['products']                             = "المواد";
$lang['check_in_items']                       = "ادخال المواد";
$lang['check_out_items']                      = "اخراج المواد";
$lang['code_error']                           = "فشل العملية, تحقق من الرمز";
$lang['r_u_sure']                             = "هل انت متأكد؟";
$lang['no_match_found']                       = "لايوجد مادة مطابقة";
$lang['unexpected_value']                     = "القيمة غير صحيحة";
$lang['username']                             = "اسم المستخدم";
$lang['password']                             = "كلمة المرور";
$lang['first_name']                           = "الاسم الأول";
$lang['last_name']                            = "الاسم الأحير";
$lang['email']                                = "البريد الالكتروني";
$lang['phone']                                = "رقم الهاتف";
$lang['gender']                               = "الجنس";
$lang['confirm_password']                     = "تأكيد كلمة المرور";
$lang['list_results']                         = "يرجى مراجعة النتيجة في الأسفل";
$lang['image']                                = "صورة";
$lang['code']                                 = "الرمز";
$lang['name']                                 = "الاسم";
$lang['category']                             = "التصنيف";
$lang['quantity']                             = "الكمية";
$lang['unit']                                 = "الوحدة";
$lang['alert_on']                             = "تنبيه عند";
$lang['actions']                              = "التعديل";
$lang['all']                                  = "الكل";
$lang['edit_item']                            = "تعديل";
$lang['delete_item']                          = "حذف";
$lang['i_m_sure']                             = "انا متأكد";
$lang['no']                                   = "متسلسل";
$lang['yes']                                  = "نعم";
$lang['alert_quantity']                       = "التنبيه عند";
$lang['enter_info']                           = "يرجى ادخال البيانات في الأسفل";
$lang['code_tip']                             = "رمز المادة\الباركود";
$lang['barcode_symbology']                    = "ترميز الباركود";
$lang['select_category']                      = "اختيار التصنيف";
$lang['product_code']                         = "رمز المادة";
$lang['product_name']                         = "اسم المادة";
$lang['category_code']                        = "رمز التصنيف";
$lang['category_name']                        = "اسم التصنيف";
$lang['image_with_ext']                       = "اسم الصورة مع لاحقة الملف";
$lang['update_info']                          = "يرجى تحديث البيانات في الأسفل";
$lang['item_added']                           = "تم اضافة المادة بنجاح";
$lang['item_updated']                         = "تم تحديث بيانات المادة بنجاح";
$lang['item_deleted']                         = "تم حذف المادة";
$lang['items_added']                          = "تم اضافة المادة";
$lang['category_added']                       = "تم اضافة التصنيف";
$lang['category_updated']                     = "تم تحديث التصنيف";
$lang['category_deleted']                     = "تم حذف التصنيف";
$lang['categories_added']                     = "تم اضافة التصنيف";
$lang['check_in_added']                       = "تم ادخال المواد بنجاح";
$lang['check_in_updated']                     = "تم تحديث ادخال المواد";
$lang['check_in_deleted']                     = "تم حذف ادخال المواد";
$lang['check_out_added']                      = "تم تخريج المواد بنجاح";
$lang['check_out_updated']                    = "تم تحديث اخراج المواد";
$lang['check_out_deleted']                    = "تم حذف اخراج المواد";
$lang['access_denied']                        = "غير مصرح بالدخول الى الصفحة";
$lang['login']                                = "دخول";
$lang['submit']                               = "ارسال";
$lang['print']                                = "طباعة";
$lang['check_in']                             = "الادخال";
$lang['add_check_in']                         = "ادخال جديد";
$lang['id']                                   = "متسلسل";
$lang['date']                                 = "Date";
$lang['reference']                            = "المرجع";
$lang['supplier']                             = "المورد";
$lang['edit_check_in']                        = "تعديل الادخال";
$lang['delete_check_in']                      = "حذف الادخال";
$lang['install']                              = "تنصيب";
$lang['update']                               = "تحديث";
$lang['backup_database']                      = "نسخ احتياطي لقاعدة البيانات";
$lang['action_x_undone']                      = "لا يمكن التراجع, سيتم الحذف النهائي من قاعدة البيانات.";
$lang['upload_file']                          = "رفع الملف";
$lang['download_sample_file']                 = "تحميل النموذج";
$lang['csv_file_tip']                         = "Please select .csv files (allowed file size 200KB)";
$lang['import']                               = "تنزيل";
$lang['csv1']                                 = "The first line in downloaded csv file should remain as it is. Please do not change the order of columns.";
$lang['csv2']                                 = "The correct column order is";
$lang['csv3']                                 = "&amp; you must follow this. If you are using any other language then English, please make sure the csv file is UTF-8 encoded and not saved with byte order mark (BOM)";
$lang['attachment']                           = "المرفق";
$lang['search_product_or_scan']               = "اكتب اسم المادة";
$lang['description']                          = "التفاصيل";
$lang['add_product_by_searching_above_field'] = "اضافة مادة من خلال البحث";
$lang['note']                                 = "ملاحظات";
$lang['item_code']                            = "رمز المادة";
$lang['check_out']                            = "الاخراج";
$lang['add_check_out']                        = "اخراج جديد";
$lang['customer']                             = "الزبون";
$lang['edit_check_out']                       = "تعديل الاخراج";
$lang['delete_check_out']                     = "حذف الاخراج";
$lang['status']                               = "الحالة";
$lang['active']                               = "فعال";
$lang['inactive']                             = "غير فعال";
$lang['select']                               = "اختيار";
$lang['male']                                 = "ذكر";
$lang['female']                               = "انثى";
$lang['update']                               = "تحديث";
$lang['site_name']                            = "اسم الشركة";
$lang['date_format']                          = "شكل التاريخ";
$lang['time_format']                          = "شكل الوقت";
$lang['default_email']                        = "بريد اساسي";
$lang['rows_per_page']                        = "عدد الصفوف في الصفحة";
$lang['disable']                              = "تعطيل";
$lang['enable']                               = "تفعيل";
$lang['update_settings']                      = "تحديث الاعدادات";
$lang['loading_data_from_server']             = "Leading data from server";
$lang['edit_category']                        = "Edit Category";
$lang['delete_category']                      = "Delete Category";
$lang['backup_on']                            = "Backup taken on ";
$lang['restore']                              = "Restore";
$lang['download']                             = "Download";
$lang['file_backups']                         = "File Backups";
$lang['backup_files']                         = "Backup Files";
$lang['database_backups']                     = "Database Backups";
$lang['db_saved']                             = "Database successfully saved.";
$lang['db_deleted']                           = "Database successfully deleted.";
$lang['backup_deleted']                       = "Backup successfully deleted.";
$lang['backup_saved']                         = "Backup successfully saved.";
$lang['backup_modal_heading']                 = "Backing up your files";
$lang['backup_modal_msg']                     = "Please wait, this could take few minutes.";
$lang['restore_modal_heading']                = "Restoring the backup files";
$lang['restore_confirm']                      = "This action cannot be undone. Are you sure about this restore?";
$lang['delete_confirm']                       = "This action cannot be undone. Are you sure about this delete?";
$lang['restore_heading']                      = "Please backup before restoring to any older version.";
$lang['full_backup']                          = 'Full Backup';
$lang['database']                             = 'Database';
$lang['files_restored']                       = 'Files successfully restored';
$lang['update_heading']                       = "This page will help you check and install the updates easily with single click. <strong>If there are more than 1 updates available, please update them one by one starting from the top (lowest version)</strong>.";
$lang['update_successful']                    = "Item successfully updated";
$lang['using_latest_update']                  = "You are using the latest version.";
$lang['version']                              = "Version";
$lang['install']                              = "Install";
$lang['changelog']                            = "Change Log";
$lang['disabled_in_demo']                     = "We are sorry but this feature is disabled in demo.";
$lang['purchase_code']                        = "Purchase Code";
$lang['envato_username']                      = "Envato Username";
$lang['delete']                               = "Delete";
$lang['please_wait']                          = "Please wait...";
$lang['change_your_password']                 = "Change your password";
$lang['change_password']                      = "Change Password";
$lang['ref']                                  = "Reference";
$lang['created_by']                           = "Created by";
$lang['created_at']                           = "Created at";
$lang['updated_by']                           = "Updated by";
$lang['updated_at']                           = "Updated at";
$lang['check_out_id']                         = "Check-out ID";
$lang['check_in_id']                          = "Check-in ID";
$lang['email_address']                        = "Email Address";
$lang['suppliers']                            = "Suppliers";
$lang['list_suppliers']                       = "List Suppliers";
$lang['add_supplier']                         = "Add Supplier";
$lang['edit_supplier']                        = "Edit Supplier";
$lang['delete_supplier']                      = "Delete Supplier";
$lang['supplier_added']                       = "Supplier successfully added";
$lang['supplier_updated']                     = "Supplier successfully updated";
$lang['supplier_deleted']                     = "Supplier successfully deleted";
$lang['customers']                            = "Customers";
$lang['list_customers']                       = "List Customers";
$lang['add_customer']                         = "Add Customer";
$lang['edit_customer']                        = "Edit Customer";
$lang['delete_customer']                      = "Delete Customer";
$lang['customer_added']                       = "Customer successfully added";
$lang['customer_updated']                     = "Customer successfully updated";
$lang['customer_deleted']                     = "Customer successfully deleted";
$lang['select_customer']                      = "Select Customer";
$lang['select_supplier']                      = "Select Supplier";
$lang['import_customers']                     = "Import Customers";
$lang['import_suppliers']                     = "Import Suppliers";
$lang['customers_added']                      = "Customers successfully added";
$lang['suppliers_added']                      = "Suppliers successfully added";
$lang['from']                                 = "From";
$lang['till']                                 = "Till";
$lang['get']                                  = "Get";
$lang['language']                             = "اللغة";
$lang['people']                               = "People";
$lang['type_hit_enter']                       = "قم بالكتابة واضغط ادخال للبحث";
$lang['item_report']                          = "تقرير المادة";
$lang['last_5_check_ins']                     = "Last 5 check-ins";
$lang['last_5_check_outs']                    = "Last 5 check-outs";
$lang['no_record_found']                      = "No record found for the item in/out";
$lang['stock_alert']                          = "تنبيه المخزون";
$lang['stores']                          = "المستودعات";
$lang['store_list']                          = "قائمة المستودعات";
$lang['add_store']                          = "اضافة مستودع";
$lang['store_name']                        = "اسم المستودع";
$lang['location']                          = "الموقع";
$lang['store']                             = "المستودع";
$lang['created_by']                          = "المستخدم";
$lang['select_store']                          = "اختيار المستودع";
$lang['choose_file']                          = "اختيارالملف";
$lang['plate number']                          = "رقم اللوحة";
$lang['serial no']                            = "الرقم التسلسلي";
$lang['plate code']                          = "رمز اللوحة";

//abdul kader(codelover138)
$lang['out_transaction']                      = "تفاصيل تفاصيل السحب";
$lang['start_date']                           = "بدء التسجيل";
$lang['end_date']                             = "تاريخ الانتهاء";
$lang['number']                               = "رقم";
$lang['select_items']                          = "اختيار العناصر";