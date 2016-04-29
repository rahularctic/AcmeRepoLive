/**
 * Created by Seifeddine on 21/04/2015.
 */
$(function () {

    $('.sandbox-containertwo :input').datetimepicker({
        format: 'YYYY-MM-DD hh:mm',
        sideBySide: true
    });

   /* $('#datetimepicker1').datetimepicker();
    $('#datetimepicker2').datetimepicker();*/

    $('.sandbox-container :input').datetimepicker({
       // format: 'YYYY-MM-DD hh:mm',
        sideBySide: true
    });

    var startDate = new Date('01/01/2012');
    var FromEndDate = new Date();
    var ToEndDate = new Date();

    ToEndDate.setDate(ToEndDate.getDate()+365);





   /* $("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker2").on("dp.change", function (e) {
        $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });
*/
    /*  $(document).on("click", ".input-group-addon", function () {

       $('#datetimepicker3').datetimepicker({
            format: "YYYY-MM-DD hh:mm",
            sideBySide: true
        });
        $('#datetimepicker23').datetimepicker({
            format: 'YYYY-MM-DD hh:mm',
            sideBySide: true
        });
        $("#datetimepicker3").on("dp.change", function (e) {
            $('#datetimepicker23').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker23").on("dp.change", function (e) {
            $('#datetimepicker3').data("DateTimePicker").maxDate(e.date);
        });

        $('#datetimepicker4').datetimepicker({
            format: "YYYY-MM-DD hh:mm",
            sideBySide: true
        });
        $('#datetimepicker24').datetimepicker({
            format: 'YYYY-MM-DD hh:mm',
            sideBySide: true
        });
        $("#datetimepicker4").on("dp.change", function (e) {
            $('#datetimepicker24').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker24").on("dp.change", function (e) {
            $('#datetimepicker4').data("DateTimePicker").maxDate(e.date);
        });

    });*/

});