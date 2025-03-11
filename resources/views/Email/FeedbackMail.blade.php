<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Feedback Recived</title>
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
                <table border="0" cellpadding="0" cellspacing="0"  style="margin:auto;">
                    <tr>
                        <td  valign="top" id="templatePreheader">
                        <h1 style="color: black;">New Feedback Given By {{ $allMailFields->name }}  </h1>
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
                      <th> Mobile :- </th>
                      <td>{{ $allMailFields->mobile }}</td>
                    </tr>
                    <tr>
                      <th> Overall Rating :- </th>
                      <td>{{ $allMailFields->overall_rating }}</td>
                    </tr>
                    <tr>
                      <th> Recommend King to friends/family? :- </th>
                      <td>{{ $allMailFields->recommend_service }}</td>
                    </tr>
                    <tr>
                      <th> Staff Name :- </th>
                      <td>{{ $allMailFields->staff_name }}</td>
                    </tr>
                    <tr>
                      <th> Staff Comment :- </th>
                      <td>{{ $allMailFields->staff_comment }}</td>
                    </tr>
                    <tr>
                      <th> Enhance Experience :- </th>
                      <td>{{ $allMailFields->enhance_experience }}</td>
                    </tr>
                    <tr>
                      <th> Did our services meet your requirements? :- </th>
                      <td>{{ $allMailFields->service_requirement }}</td>
                    </tr>
                    <tr>
                      <th> How could we have a better engagement with you? :- </th>
                      <td>{{ $allMailFields->feedback_suggestion }}</td>
                    </tr>
                    <tr>
                      <th> Happy for King to use your feedback :- </th>
                      <td>{{ $allMailFields->market_activity }}</td>
                    </tr>
                  </tbody>                     
                </table>
            </td>
        </tr>
    </table>
</body>

</html>