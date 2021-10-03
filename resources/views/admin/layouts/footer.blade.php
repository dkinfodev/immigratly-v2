<!-- Sidebar -->
<div id="reminderNotesSidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
   <div class="card card-lg sidebar-card sidebar-scrollbar">
      <div class="card-header">
         <h4 class="card-header-title">Reminder Notes</h4>
         <!-- Toggle Button -->
         <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
            data-hs-unfold-options='{
            "target": "#reminderNotesSidebar",
            "type": "css-animation",
            "animationIn": "fadeInRight",
            "animationOut": "fadeOutRight",
            "hasOverlay": true,
            "smartPositionOff": true
            }'>
         <i class="tio-clear tio-lg"></i>
         </a>
         <!-- End Toggle Button -->
      </div>
      <!-- Body -->
      <div class="card-body sidebar-body">
         <div class="chat_window">
            <ul class="messages">
               
            </ul>
            <div class="doc_chat_input text-center bottom_wrapper clearfix">
               <a class="btn btn-soft-success btn-lg" data-toggle="tooltip" data-placement="top" title="Add reminder notes" onclick="showPopup('<?php echo baseUrl('add-reminder-note') ?>')">
                  <i class="tio-calendar"></i> Add Notes
                </a>
            </div>
         </div>
         <div class="message_template">
            <li class="message">
               <div class="avatar"></div>
               <div class="text_wrapper">
                  <div class="text"></div>
               </div>
            </li>
         </div>
      </div>
      <!-- End Body -->
   </div>
</div>

<!-- End Sidebar -->  
<script type="text/javascript">
function fetchReminderNotes(){
  $.ajax({
    type: "POST",
    url: "{{ baseUrl('fetch-reminder-notes') }}",
    data:{
        _token:csrf_token,
    },
    dataType:'json',
    beforeSend:function(){
   
    },
    success: function (response) {
        if(response.status == true){
           $("#reminderNotesSidebar .messages").html(response.html);
           setTimeout(function(){
              // $("#reminderNotesSidebar .messages").mCustomScrollbar();
              $("#reminderNotesSidebar .messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
             
              $('.js-hs-action').each(function () {
                var unfold = new HSUnfold($(this)).init();
              });
           },800);
        }else{
           errorMessage(response.message);
        }
    },
    error:function(){
     $("#reminderNotesSidebar .messages").html('');
     internalError();
    }
  });
}
</script>