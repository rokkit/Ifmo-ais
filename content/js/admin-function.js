/**
 * Created with JetBrains PhpStorm.
 * User: rokkitlanchaz
 * Date: 02.06.12
 * Time: 11:33
 * To change this template use File | Settings | File Templates.
 */
function createAutoClosingAlert(selector, delay) {
    var alert = $(selector).alert();
    window.setTimeout(function() { alert.alert('close') }, delay);
}