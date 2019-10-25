<?php
session_start();
include_once('database_connection.php');
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat Application using PHP Ajax jQuery</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
</head>
<style>
    .chat_message_area {
        position: relative;
        width: 100%;
        height: auto;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    #group_chat_message {
        width: 100%;
        height: auto;
        min-height: 80px;
        overflow: auto;
        padding: 6px 24px 6px 12px;
    }

    .image_upload {
        position: absolute;
        top: 3px;
        right: 3px;
    }

    .image_upload>form>input {
        display: none;
    }

    .image_upload img {
        width: 24px;
        cursor: pointer;
    }
</style>

<body>
    <div class="container">
        <br />
        <h3 align="center">Chat Application using PHP Ajax jQuery</h3>
        <br /><br />
        <div class="row">
            <div class="col-md-8 col-sm-6">
                <h4 align="center">Online User</h4>
            </div>
            <div class="col-md-2 col-sm-3">
                <input type="hidden" id="is_active_group_chat_window" value="no">
                <button type="button" name="group_chat" id="group_chat" class="btn btn-warning btn-xs">Group Chat</button>
            </div>
            <div class="col-md-2 col-sm-3">
                <p align="right">Hi - <?php echo $_SESSION['username']; ?> - <a href="logout.php">Logout</a></p>
            </div>
        </div>
        <div class="table table-responsive">
            <div id="user_details"></div>
            <div id="user_model_details"></div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            fetch_user();

            setInterval(function() {
                update_last_activity();
                fetch_user();
                update_chat_history_data();
                fetch_group_chat_history();
            }, 5000)

            function fetch_user() {
                $.ajax({
                    url: 'fetch_user.php',
                    method: 'post',
                    success: function(data) {
                        $('#user_details').html(data)
                    }
                })
            }

            function update_last_activity() {
                $.ajax({
                    url: 'update_last_activity.php',
                    success: function() {

                    }
                })
            }

            function make_chat_dialog_box(to_user_id, to_user_name) {
                var modal_content = '<div id="user_dialog_' + to_user_id + '" class="user_dialog" title="You have chat with ' + to_user_name + '">';
                modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y:scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="' + to_user_id + '" id="chat_history_' + to_user_id + '">';
                modal_content += fetch_user_chat_history(to_user_id);
                modal_content += '</div>';
                modal_content += '<div class="form-group">';
                modal_content += '<textarea name="chat_message_' + to_user_id + '" id="chat_message_' + to_user_id + '" class="form-control chat-message"></textarea>';
                modal_content += '</div><div class="form-group" align="right">';
                modal_content += '<button type="button" name="send_chat" id="' + to_user_id + '" class="btn btn-info send_chat">Send</button></div></div>';
                $('#user_model_details').html(modal_content);
            }

            $(document).on('click', '.start_chat', function() {
                var to_user_id = $(this).data('touserid');
                var to_user_name = $(this).data('tousername');
                make_chat_dialog_box(to_user_id, to_user_name);
                $("#user_dialog_" + to_user_id).dialog({
                    autoOpen: false,
                    width: 400
                });
                $("#user_dialog_" + to_user_id).dialog('open');
                $("#chat_message_" + to_user_id).emojioneArea({
                    pickerPosition: "top",
                    toneStyle: "bullet"
                });
            });

            $(document).on('click', '.send_chat', function() {
                var to_user_id = $(this).attr('id');
                var chat_message = $('#chat_message_' + to_user_id).val();
                $.ajax({
                    url: "insert_chat.php",
                    method: "post",
                    data: {
                        to_user_id: to_user_id,
                        chat_message: chat_message
                    },
                    success: function(data) {
                        //$('#chat_message_' + to_user_id).val('');
                        var element = $("#chat_message_" + to_user_id).emojioneArea();
                        element[0].emojioneArea.setText('');
                        $('#chat_history_' + to_user_id).html(data);
                    }
                })
            });

            function fetch_user_chat_history(to_user_id) {
                $.ajax({
                    url: "fetch_user_chat_history.php",
                    method: "post",
                    data: {
                        to_user_id: to_user_id
                    },
                    success: function(data) {
                        $('#chat_history_' + to_user_id).html(data);
                    }
                })
            }

            function update_chat_history_data() {
                $('.chat_history').each(function() {
                    var to_user_id = $(this).data('touserid');
                    fetch_user_chat_history(to_user_id);
                });
            }

            $(document).on('focus', '.chat-message', function() {
                var is_type = 'yes';
                $.ajax({
                    url: 'update_is_type_status.php',
                    method: 'post',
                    data: {
                        is_type: is_type
                    },
                    success: function() {

                    }
                })
            });

            $(document).on('blur', '.chat-message', function() {
                var is_type = 'no';
                $.ajax({
                    url: 'update_is_type_status.php',
                    method: 'post',
                    data: {
                        is_type: is_type
                    },
                    success: function() {

                    }
                })
            })

            $("#group_chat_dialog").dialog({
                autoOpen: false,
                width: 400
            });

            $("#group_chat").click(function() {
                $("#group_chat_dialog").dialog('open');
                $("#is_active_group_chat_window").val('yes');
                fetch_group_chat_history();
                // $("#group_chat_message").emojioneArea({
                //     pickerPosition: "top",
                //     toneStyle: "bullet"
                // });
            });

            $("#send_group_chat").click(function() {
                var chat_message = $('#group_chat_message').html();
                var action = 'insert_data';
                if (chat_message != '') {
                    $.ajax({
                        url: 'group_chat.php',
                        method: 'post',
                        data: {
                            chat_message: chat_message,
                            action: action
                        },
                        success: function(data) {
                            $('#group_chat_message').html('');
                            // var element = $("#group_chat_message").emojioneArea();
                            // element[0].emojioneArea.setText('');
                            $('#group_chat_history').html(data);
                        }
                    })
                }
            });

            function fetch_group_chat_history() {
                var group_chat_dialog_active = $("#is_active_group_chat_window").val();
                var action = "fetch_data";
                if (group_chat_dialog_active == 'yes') {
                    $.ajax({
                        url: 'group_chat.php',
                        method: 'post',
                        data: {
                            action: action
                        },
                        success: function(data) {
                            $('#group_chat_history').html(data);
                        }
                    })
                }
            }

            $('#uploadFile').on('change', function() {
                $('#uploadImage').ajaxSubmit({
                    target: "#group_chat_message",
                    resetForm: true
                })
            })

            $(document).on('click', '.remove_chat', function() {
                var chat_message_id = $(this).attr('id');
                if (confirm("Are you sure you want to remove this chat?")) {
                    $.ajax({
                        url: 'remove_chat.php',
                        method: 'post',
                        data: {
                            chat_message_id: chat_message_id
                        },
                        success: function() {
                            update_chat_history_data();
                        }
                    })
                }
            })
        });
    </script>
</body>

</html>
<div id="group_chat_dialog" title="Group Chat Window">
    <div id="group_chat_history" style="height:400px; border:1px solid #ccc; overflow-y:scroll; margin-bottom:24p; padding:16px;"></div>
    <div class="form-group">
        <!-- <textarea name="group_chat_message" id="group_chat_message" class="form-control"></textarea> -->
        <div class="chat_message_area">
            <div id="group_chat_message" contenteditable class="form-control"></div>
            <div class="image_upload">
                <form action="upload.php" method="post" id="uploadImage">
                    <label for="uploadFile"><img src="upload.png"></label>
                    <input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png">
                </form>
            </div>
        </div>
    </div>
    <div class="form-group" align="right">
        <button type="button" name="send_group_chat" id="send_group_chat" class="btn btn-info">Send</button>
    </div>
</div>