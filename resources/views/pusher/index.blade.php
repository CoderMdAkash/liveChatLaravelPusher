<!DOCTYPE html>
<head>
  <title>Pusher Test</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 pt-5">
                <div class="card">
                    <div class="card-header">
                        <h5><div class="text-info" style="float: left"> {{Auth::user()->name}}</div><div class="text-success text-right" style="float: right">Active</div></h5>
                    </div>
                    
                    <div class="card-body">

                        <form action="{{url('broadcust-pusher-post')}}" method="POST" id="chat-submit">
                            @csrf
                            <div class="form-group">
                                <div id="message-show" style="height: 60vh;overflow-y:scroll;padding:5px">
                                    
                                </div>
                                <br>
                                <div class="input-group mb-3">
                                    <input id="message" type="text" class="form-control" name="message" placeholder="Write Message" aria-label="Write Message" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                      <button class="btn btn-info" id="send-btn" type="submit">Send</button>
                                    </div>
                                </div>
                            </div>
                          
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function(){

        Pusher.logToConsole = true;

        var pusher = new Pusher('70b10d0716ef92295cf8', {
        cluster: 'mt1'
        });

        var channel = pusher.subscribe('channel-message');
        channel.bind('MessageEvent', function(data) {
            // alert(JSON.stringify(data['message']));
            messageShow()
        });

        messageShow();

        function messageShow(){
            $.ajax({
                method: 'get',
                url: "{{url('broadcust-mgs-show')}}",
                type: 'html',
                success: function (data) {
                    $("#message-show").html(data);
                    $("#message-show").scrollTop($("#message-show")[0].scrollHeight);
                },
                error:function(data){
                    alert("error");
                    console.log(data);
                }
            });
        }



        $(document).on('submit', '#chat-submit', function(e){
            e.preventDefault();
            let mgs = $("#message").val();

            $("#send-btn").text('Sending..');
            $("#send-btn").attr('disabled', true);

            if(mgs != ""){
                let formData = new FormData($(this)[0]);
                let url = $(this).attr('action');

                $.ajax({
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    enctype: 'multipart/form-data',
                    url: url,
                    success: function (data) {
                        $("#message").val('');
                        // alert(data.message);
                        messageShow(); 
                        $("#send-btn").text('Send');
                        $("#send-btn").attr('disabled', false);
                    },
                    error:function(data){
                        alert("error");
                        console.log(data);
                    }
                });

            }else{
                alert("please Write Message");
            }
        })
    })
</script>
</body>