@extends('staffAdmin.staffAdminMaster')


@section('adminpanel')

<div class="wrapper">
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="page-title">UserChats</h2>
                    
                    @if(isset($users_all_questions))
                        <div class="chat-container" style="overflow-y: auto; overflow-x: hidden; height: 400px;">
                            @foreach($users_all_questions as $item)
                                @if($item->answer === null)
                                    <div class="user-question">
                                        @if(isset($user_name))
                                        @foreach($user_name as $data)
                                        @if(!empty($data->userImage))
                                        <img src="{{ asset('public/assets/userImage/' . $data->userImage) }}" class="user-icon">
                                        @else
                                            <img src="{{ asset('assets/userImage/defaultUserImage.png') }}"class="user-icon">
                                        @endif
                                        @endforeach
                                        @endif
                                        <div class="question-bubble">
                                            <strong>@if(isset($user_name))@foreach($user_name as $data) {{$data->name}} @break @endforeach @endif</strong><br> {{ $item->question }}
                                        </div>
                                    </div>
                                    <span class="timestamp">{{ $item->qtime }}</span>
                                @else
                                    <div class="bot-answer">
                                        <div class="answer-bubble">
                                            <strong>AMI</strong><br> {{ $item->answer }}
                                            <div class="timestamp-container">
                                                <span class="ans-order">{{ $item->chatorder }}</span>
                                            </div>
                                        </div>
                                        <div class="bot-info">
                                            <img class="bot-icon" src="{{ asset('assets/squirrel.png') }}">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <br>
                           
                            <br>
                            <br>    
                        </div>
                         <form class="message-form" method="post" action="{{ url('addchatans') }}">
                                @csrf
                                <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                                @foreach($users_all_questions as $item)
                                    @if($item->answer === null)
                                        <input type="hidden" name="chatQuestionId" value="{{ $item->quid }}">
                                        @break
                                    @endif
                                @endforeach
                                {{-- <input type="text" id="answer" name="answer" class="message-input" placeholder="Enter your message...">
                                <button type="submit" class="send-button">Send</button> --}}
                               
                                   <input type="text" id="answer" name="answer" class="message-input" placeholder="Enter your message...">
                                    &nbsp;<button type="button" class="refresh-button" onclick="refreshPage()"><i class="fas fa-sync"></i></button>
                                    <button type="submit" class="send-button">Send</button>
                                </div>
                                
                            </form>
                        <br>
                        <br>
                        <br>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    function refreshPage() {
    location.reload();
}

    </script>
<script>
    // Add this script after the chat container
    var chatContainer = document.querySelector('.chat-container');
    var lastMessage = document.querySelector('.chat-container .message:last-child');
    var messageForm = document.querySelector('.message-form');

    // Scroll to the last message or the input form
    var scrollToLast = function() {
        if (lastMessage && lastMessage.offsetTop > chatContainer.scrollTop + chatContainer.offsetHeight) {
            chatContainer.scrollTop = lastMessage.offsetTop;
        } else {
            chatContainer.scrollTop = messageForm.offsetTop;
        }
    };

    // Scroll to the last message or the input form when the page is loaded or resized
    window.addEventListener('load', scrollToLast);
    window.addEventListener('resize', scrollToLast);
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>

.input-container {
    display: flex;
    align-items: center;
}

.message-input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.refresh-button,
.send-button {
    background-color: #f2f2f2;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
}

.refresh-button:hover,
.send-button:hover {
    background-color: #ddd;
}

/* Adjust the icon size */
.fas {
    font-size: 16px;
    /* You can adjust the size as needed */
    /* For example: font-size: 20px; */
}

    </style>


<style>
* {
    font-family: 'Avenir', sans-serif;
}

.page-title {
    text-align: center;
}

.chat-container {
    border: 3px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    /* background-color: #eef1e9 */
}

.user-question, .bot-answer {
    display: flex;
    align-items: flex-start;
}

.user-icon, .bot-icon {
    width: 40px;
    height: 40px;
    margin-right: 10px;
}

.question-bubble, .answer-bubble {
    padding: 10px 15px;
    border-radius: 20px;
    background-color: #3caaf3;
    color: white;
    max-width: 70%;
}

.question-bubble {
    border-radius: 20px 20px 20px 0;
}

.answer-bubble {
    border-radius: 20px 20px 0 20px;
    background-color: #9be485;
    margin-left: auto;
    margin-top: 10px;
    color: rgb(15, 15, 15);
}

.timestamp-container {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-top: 5px;
}

.timestamp {
    font-size: 12px;
    color: grey;
    margin-left: 5px;
}

.ans-order {
    font-size: 12px;
    color: grey;
    margin-left: auto;
}

.bot-info {
    display: flex;
    align-items: center;
    margin-bottom: 10px; 
}

.bot-icon {
    width: 40px;
    height: 40px;
    margin-right: 10px;
}

.message-form {
    margin-top: 20px;
    display: flex;
}

.message-input {
    flex-grow: 1;
    padding: 10px;
    border-radius: 20px;
    border: 1px solid #ddd;
}

.send-button {
    padding: 10px 15px;
    margin-left: 10px;
    border: none;
    border-radius: 20px;
    background-color: #26502f;
    color: #fff;
    cursor: pointer;
}
</style>







 















<!-- TO SHOw LAODER -->
   
    <!-- FORM FOR MODEL TO SHOW VALUES -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <script src='js/dataTables.bootstrap4.min.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    



    
    <script src='js/jquery.dataTables.min.js'></script>
    <script src='js/dataTables.bootstrap4.min.js'></script>

    <script>
        $('#dataTable-1').DataTable(

            {
                autoWidth: true,
                "lengthMenu": [
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
                ]
            });
    </script>



@endsection