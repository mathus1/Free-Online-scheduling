<?php
require_once 'core/init.php';
is_logged_in();

$past=strtotime("-2 Months");
$query1 = "SELECT * FROM events ORDER BY id";
$statement1 = $connect->prepare($query1);
$statement1->execute();
$result1 = $statement1->fetchAll();
foreach($result1 as $row1)
{
if (strtotime($row1['end_event']) < $past) {
  $query = "
  DELETE from events WHERE id=:id
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    ':id' =>$row1['id']
   )
  );
}}
include 'includes/head.php';
include 'includes/navigation.php';
 ?>
  <br />
  <h2 align="center">Schedule</h2>
  <br />
  <div class="container">
   <div id="calendar"></div>

   <div id="id01" class="w3-modal" style="z-index:999;">
       <div class="w3-modal-content w3-container w3-card-4 w3-animate-zoom w3-light-gray" style="max-width:600px">

         <div class="w3-center w3-padding"><h3>Add Event</h3><br>
           <span onclick="document.getElementById('id01').style.display='none'; $('#msg').text('');" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
         </div>

           <div class="w3-section">
             <label><b>Title</b></label>
             <input class="w3-input w3-border w3-margin-bottom" type="text" id="title" value="" placeholder="Enter Title" required>
             <?php $permissions = explode('.',$user_data['permissions']);
              if(in_array('admin',$permissions)){   ?>
                <label><b>Assign to:</b></label>
             <select id="userid" class="w3-input w3-border w3-margin-bottom">
               <?php $query = mysqli_query($db,"SELECT * FROM users WHERE confirmed='1' ");
                   while ($user = mysqli_fetch_assoc($query)) { ?>
                     <option value="<?php echo $user['id'];?>" <?php echo (($user['id'] == $user_data['id'])?'selected':'');?> ><?php echo $user['full_name'];?></option>
                  <?php } ?>
              </select>
            <?php } else { ?> <input class="w3-input w3-border w3-margin-bottom" type="hidden" id="userid" value="<?php echo $user_data['id'];?>">  <?php } ?>
             <label><b>Description</b></label>
             <textarea class="w3-input w3-border w3-margin-bottom" id="description" placeholder="Enter Description"></textarea>
               <div class="w3-row">
              <div class="w3-col m6">
             <label><b>Start Date</b></label><br>
             <input type="text" "w3-input w3-border w3-margin-bottom" id="start"  >
              </div>
              <div class="w3-col m6">
             <label><b>End date</b></label><br>
             <input type="text" "w3-input w3-border w3-margin-bottom" id="end" >
            </div>
            </div><br>
             <label for="color"><b> Select color:</b></label>
             <input type="color" id="color" value="#ff0000"><br><br>
             <a class="w3-button w3-block w3-teal w3-card-4 w3-padding w3-round-xlarge w3-ripple" id="add"><b>Add</b></a>
           </div>

         <div class="w3-border-top ">
           <p class="w3-text-red w3-large w3-center" id="msg"></p>
         </div>

       </div>
     </div>


     <div id="id02" class="w3-modal" style="z-index:999;">
         <div class="w3-modal-content w3-container w3-card-4 w3-animate-zoom w3-light-gray" style="max-width:600px">

           <div class="w3-center w3-padding"> <h3>Edit Event</h3<br>
             <span onclick="document.getElementById('id02').style.display='none'; $('#msg2').text('');" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
           </div>

             <div class="w3-section">
               <label><b>Title</b></label>
               <input class="w3-input w3-border w3-margin-bottom" type="text" id="title2" value="" placeholder="Enter Title" required>
               <?php $permissions = explode('.',$user_data['permissions']);
                if(in_array('admin',$permissions)){   ?>
              <label><b>Assign to:</b></label>
               <select id="userid2" class="w3-input w3-border w3-margin-bottom">
                 <?php $query = mysqli_query($db,"SELECT * FROM users WHERE confirmed='1' ");
                     while ($user = mysqli_fetch_assoc($query)) { ?>
                       <option value="<?php echo $user['id'];?>"><?php echo $user['full_name'];?></option>
                    <?php } ?>
                </select>
              <?php } else { ?> <input class="w3-input w3-border w3-margin-bottom" type="hidden" id="userid2" value="<?php echo $user_data['id'];?>">  <?php } ?>
               <input class="w3-input w3-border w3-margin-bottom" type="hidden" id="idedit" value="">
               <label><b>Description</b></label>
               <textarea class="w3-input w3-border w3-margin-bottom" id="description2" placeholder="Enter Description"></textarea>
               <label for="color2"><b> Select color: </b></label>
               <input type="color" id="color2"  value="#ff0000"><br><br>
               <div class="w3-center"><a class="w3-button w3-light-blue w3-card-4 w3-padding w3-round-xlarge w3-ripple w3-margin" style="width:100px;" id="edit"><b>Edit<b/></a><a class="w3-button w3-red w3-card-4 w3-padding w3-round-xlarge w3-ripple w3-margin" style="width:100px;" id="delete"><b>Delete</b></a></div>
             </div>

           <div class="w3-border-top ">
             <p class="w3-text-red w3-large w3-center" id="msg2"></p>
           </div>

         </div>
       </div>


  </div>

  <script type="text/javascript">
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay,listWeek'
    },
    events: 'load.php',
    selectable:true,
    selectHelper:true,
    displayEventTime: false,
    timeZone: 'Asia/Seoul',
    themeSystem: 'bootstrap4',
    select: function(start, end, allDay)
    {
    document.getElementById('id01').style.display='block';

     var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
     var startc = convertstarttoinput(Date.parse(start));
     var endc = convertendtoinput(Date.parse(end)-43250000);
     $('#start').val(startc);
     $('#end').val(endc);

    },
    editable:true,

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     var description = event.description;
     var color = event.color;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, description:description, color:color, start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Event Updated");
      }
     });
    },
    eventRender: function(event, element) {
           // To append if is description in next line
           var startf = convertstarttoinput(event.start -32400000);
           var endf = convertendtoinput(event.end -32400000);
           startf= startf.substring(5);
           endf = endf.substring(5);
           startf= startf.replace("T", " ");
           endf = endf.replace("T", " ");
           startf= startf.replace("-", "/");
           endf = endf.replace("-", "/");

           var userid = event.userid;
           $.ajax({
            url:"parseuser.php",
            type:"POST",
            data:{userid:userid},
            success:function(data)
            {
              var obj = JSON.parse(data);
              if (obj.image !='') {
              var imgtag = '<img src="'+obj.image+'" height="30" width="30" class="w3-bar-item w3-circle w3-card-4"></img>';
              } else {
              var imgtag = '<i class="fa fa-user-circle-o w3-large"></i>';
              }

               element.popover({
              title: event.title,
              content: event.description,
              trigger: 'hover',
              delay:300,
              placement: 'top',
              theme: 'material',
              template: '<div class="popover w3-card-4 popover1" role="tooltip" ><div class="arrow"></div><h3 class="popover-header  bg-primary text-white w3-round-large w3-center w3-margin"></h3><div class="w3-margin">'+imgtag+'<b class="w3-margin w3-small">'+obj.name+'</b></div><div class="popover-body"></div></div>',
              container: 'body'
              });

            }
          });



            element.find(".fc-title").prepend("<b class='w3-tiny'><span class='w3-round w3-pale-yellow' style='box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); padding:1px;'> " + startf + "</span>&#10148;<span class='w3-round w3-pale-yellow' style='box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); padding:1px;'>" + endf + "</span></b><br/>");

           if(event.description != '' && typeof event.description  !== "undefined")
           {
               element.find(".fc-title").append("<br/><b class='w3-tiny'>"+truncate(event.description, 15)+"</b>");

           }
       },

    eventClick:function(event)
    {
      var id = event.id;
      var title = event.title;
      var description = event.description;
      var color = event.color;
      var start = event.start;
      var end = event.end;
       $('#title2').val(title);
       $('#description2').val(description);
       $('#color2').val(color);
       $('#idedit').val(id);
       $("#userid2 option[selected='selected']").removeAttr('selected');
       $("#userid2 option[value='"+event.userid+"']").attr('selected', 'selected');
      document.getElementById('id02').style.display='block';
    },

   });
   $("#delete").click(function(){
  var id = $('#idedit').val();
  if (confirm("Do you want to remove the event?")) {

   $.ajax({
    url:"delete.php",
    type:"POST",
    data:{id:id},
    success:function()
    {
      calendar.fullCalendar('refetchEvents');
      document.getElementById('id02').style.display='none';
    }
   })
   }
  });

  $("#edit").click(function(){
  var title = $('#title2').val();
  var id = $('#idedit').val();
  var description = $('#description2').val();
  var color = $('#color2').val();
  var userid = $('#userid2').val();
  $.ajax({
  url:"edit.php",
  type:"POST",
  data:{title:title, description:description, color:color, userid:userid, id:id},
  success:function()
  {
   calendar.fullCalendar('refetchEvents');
   document.getElementById('id02').style.display='none';
  }
  });
  });

  $("#add").click(function(){

  var title = $('#title').val();
  var description = $('#description').val();
  var userid = $('#userid').val();
  var color = $('#color').val();
  var startc = $('#start').val();
  var endc = $('#end').val();
  var start = startc.replace("T", " ")+":00";
  var end =  endc.replace("T", " ")+":00";

  if(title) { if(Date.parse(start) < Date.parse(end)){

  $.ajax({
  url:"insert.php",
  type:"POST",
  data:{title:title, description:description, userid:userid, color:color, start:start, end:end},
  success:function()
  {
    start = '';
    startc = '';
    end = '';
    endc = '';
    title = '';
    description = '';
    color = '#ff0000';
   $('#title').val('');
   $('#start').val('');
   $('#end').val('');
   $('#description').val('');
   $('#msg').text('');
   $('#color').val('#ff0000');
   calendar.fullCalendar('refetchEvents');
   document.getElementById('id01').style.display='none';
  }
  })
  }else {$('#msg').text('End date must be after the Start date');}} else {$('#msg').text('Insert title');}  });


  });

  function truncate(str, no_words) {
    if (str.split(" ").length < no_words) {
      return str.split(" ").splice(0,no_words).join(" ");
    } else {
      return str.split(" ").splice(0,no_words).join(" ")+" ...";
    }
    }

    function convertstarttoinput(timestamp){
      result = moment.tz(timestamp, "Asia/Seoul").format();
      result = result.slice(0, -9)
      return result;

  }

  function convertendtoinput(timestamp){;
    result = moment.tz(timestamp, "Asia/Seoul").format();
    result = result.slice(0, -9)
  return result;

  }
$.datetimepicker.setLocale('en');
$('#start').datetimepicker();
$('#end').datetimepicker();


  </script>

<?php include 'includes/footer.php'; ?>
