# Payment_to_the_House_Committee

<!DOCTYPE HTML>
<html>
<head>
    <!--   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment to the House Committee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">

    // RefreshAjax
        $(document).ready(function () {
            $("#RefreshAjax").click(function () {
                $.get("data.json", function (data, status) {
                   cache: false,
                   data = $.parseJSON(data);
                    for (var i = 0; i < data.length; i++) 
					{
                        $("#tenant" + i).html('Apartment Number:' + data[i].ApartmentNumber + '<br /> ' + data[i].firstName + ' ' + data[i].lastName + '<br /> is a ' + data[i].Type + '<br /> floor:' + data[i].floor);
                        if (data[i].debt == true) 
						{
                            $("#tenant" + i).css("background-color", "red").append("<br><button id=" + (data[i].ApartmentNumber) + " type='button'>Pay " + data[i].sumdebt + " ILS </button>");
                        }
                        else
                        { 
							$("#tenant" + i).css("background-color", "green");
						}

		 
                            $('#tenant' + i).click(function () {
                                alert("1");
                                alert(data[i].ApartmentNumber);
                                window.location.replace("http://stackoverflow.com");

                                window.location.href ="https://secure.cardcom.co.il/External/ExternalClearingPage3.aspx?TerminalNumber=1001&Languages=en&description=Payment_to_the_House_Committee&sum=2&PageTxtDesc=0&InvCreateInvoice=1";
                            });                       
                    }
                });
            });
        }); 
  
    </script>
</head>
<body>
    <div class="container span6">
        <div class="table-responsive">
            <button id="RefreshAjax">
                Refresh Ajax</button>
            <!--      <table id="mytable" class="tblStyle">-->
            <table class="table">
                <tr class="Info">
                    <td id="tenant0">
                    </td>
                </tr>
                <tr class="Info">
                    <td id="tenant1">
                    </td>
                </tr>
                <tr class="Info">
                    <td id="tenant2">
                    </td>
                </tr>
                <tr class="Info">
                    <td id="tenant3">
                    </td>
                </tr>
            </table>
            <div class="showclass" id="showdiv">
            </div>
        </div>
    </div>
</body>
</html>
