<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <title>Eva-Chatbot</title>
    <script src="web/js/jquery.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            var localUrl = window.location.href;
            localUrl = localUrl.replace('web/', '');

            // só um advinhador simples
            var webServiceUrl = window.location.href + 'api.php';
            console.log(webServiceUrl);
            $('.clean').click(function () {

                Clear();
                AddText('system ', 'cleaning...');

                $('.userMessage').hide();

                $.ajax({
                    type: "GET",
                    url: webServiceUrl,
                    data: {
                        requestType: 'forget'
                    },
                    success: function (response) {
                        AddText('system ', 'Ok!');
                        $('.userMessage').show();
                    },
                    error: function (request, status, error) {
                        Clear();
                        alert('error');
                        $('.userMessage').show();
                    }
                });
            });


            $('#fMessage').submit(function () {

                // get user input
                var userInput = $('input[name="userInput"]').val();

                // basic check
                if (userInput == '')
                    return false;
                //

                // clear
                $('input[name="userInput"]').val('');

                // hide button
                $(this).hide();

                // show user input
                AddText('A ', userInput);

                $.ajax({
                    type: "GET",
                    url: webServiceUrl,
                    data: {
                        userInput: userInput,
                        requestType: 'talk'
                    },
                    success: function (response) {
                        console.log(webServiceUrl);
                        console.log(userInput);
                        AddText('B ', response.message);
                        $('#fMessage').show();
                        $('input[name="userInput"]').focus();
                    },
                    error: function (request, status, error) {
                        console.log(error);
                        alert('error');
                        $('#fMessage').show();
                    }
                });

                return false;
            });

            function Clear() {
                $('.chatBox').html('');
            }

            function AddText(user, message) {
                console.log(user);
                console.log(message);

                var div = $('<div>');
                var name = $('<labe>').addClass('name');
                var text = $('<span>').addClass('message');

                name.text(user + ':');
                text.text('\t' + message);

                div.append(name);
                div.append(text);

                $('.chatBox').append(div);

                $('.chatBox').scrollTop($(".chatBox").scrollTop() + 100);
            }


        });
    </script>
</head>
<body id="body">
<center>
    <div id="box1">
        <br>
        <br>
        <br>
        <br>
        <div class="chatBox">
            welcome , i am chatbot ...
        </div>
        <div>
            <br>
        </div>
    </div>
    <div id="box2" class="userMessage">
        <form id="fMessage">
            <input id="clean" type="button" class="clean" value="clean"/>
            <input type="text" name="userInput" id="userInput"/>
            <input id="send" type="submit" value="send" class="send"/>
        </form>
    </div>
</center>
</body>


</html>
