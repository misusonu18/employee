        </main>
            </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
                <script src="js/alertify.min.js"></script>
                <script src="js/scripts.js"></script>

                <?php
                    if (isset($insert)) {
                        echo "
                            <script type='text/javascript'>
                                alertify.notify('Insert Successfully', 'success', 2, function(){
                                    window.location.href='index.php';
                                });
                            </script>
                        ";
                    }

                    if (isset($update)) {
                        echo "
                            <script type='text/javascript'>
                                alertify.notify('Update Successfully', 'success', 2, function(){
                                    window.location.href='index.php';
                                });
                            </script>
                        ";
                    }

                    if (isset($delete)) {
                        echo "
                            <script type='text/javascript'>
                                alertify.notify('Delete Successfully', 'success', 2, function(){
                                    window.location.href='index.php';
                                });
                            </script>
                        ";
                    }

                ?>
    </body>
</html>
