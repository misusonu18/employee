function confirmation() {
    alertify.confirm("Delete Employee", "Do You Really Want To Delete Employee?", function (e) {
        event.preventDefault();
        if (e) {
            document.getElementById("delete-employee-form").submit();
            alertify.set('notifier', 'position', 'top-center');
            return true;
        } else {
            return false;
        }
    },
        function () {}
    );
}
