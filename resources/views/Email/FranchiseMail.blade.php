<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Franchise Mail</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        @media (max-width:600px) {
            table.main_outter {
                width: 100% !important;
                padding: 0 15px !important;
            }

            body,
            table {
                width: 100% !important;
            }
        }
    </style>
</head>

<body style="width:600px;margin:auto;background: #ececec;" width="600px">
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="600px" id="bodyTable"
        style="background: #ececec;padding: 20px 0px 40px;">
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" style="margin:auto;">
                    <tr>
                        <td valign="top" id="templatePreheader">
                            <h1 style="color: black;">New Franchise Enquiry Request By {{ $allMailFields->name }} From {{
                                $allMailFields->query_from }} Form </h1>
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th> Name :- </th>
                            <td>{{ $allMailFields->name }}</td>
                        </tr>
                        <tr>
                            <th> Email :- </th>
                            <td>{{ $allMailFields->email }}</td>
                        </tr>
                        <tr>
                            <th> Phone :- </th>
                            <td>{{ $allMailFields->mobile }}</td>
                        </tr>
                        <tr>
                            <th> City :- </th>
                            <td>{{ $allMailFields->city }}</td>
                        </tr>
                        <tr>
                            <th> Investment Type :- </th>
                            <td>{{ $allMailFields->investment_type }}</td>
                        </tr>
                        <tr>
                            <th> Business Type :- </th>
                            <td>{{ $allMailFields->business_type }}</td>
                        </tr>
                        <tr>
                            <th> How You Know :- </th>
                            <td>{{ $allMailFields->how_you_know }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>