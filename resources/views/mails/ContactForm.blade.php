<html>
    <body style="background-color: #f1f1f1; padding: 20px;">
        <h2 style="text-align: center">QurannAcademy Contact Form</h2> <br><br>
        <p style="font-size: 16px; color: #4e4e4e">
            You received an email from : {{ $data['full_name'] }} <br><br>

            User details: <br><br>
            
            Name:  {{ $data["full_name"] }}<br>
            Email:  {{ $data['email'] }}<br>
            Message:  {!! $data['message'] !!}<br><br>
            
            Thanks
        </p>
        
    </body>
</html>

