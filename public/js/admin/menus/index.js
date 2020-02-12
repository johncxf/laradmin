$(document).ready(function() {
    Wind.css('treeTable');
    Wind.use('treeTable', function() {
        $("#menus-table").treeTable({
            indent : 20,
            initialState: 'expanded'
        });
    });
});
