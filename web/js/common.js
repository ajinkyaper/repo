/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
Version 2.0
*/

$('#frm_date,#t_date').datepicker({
    format: "dd-mm-yyyy",
    clearBtn: true,
    autoclose: true,
    endDate: '+1d',
    datesDisabled: '+1d',
});