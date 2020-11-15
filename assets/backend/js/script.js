(function($){
  $(document).ready(function(){

    // Set All Users info in the User table
    view_all_Users();

    //  After Click on View button in User table
    $(document).on('click','#user_data_view',function(e){
      e.preventDefault();
      let user_id = $(this).attr('user_id');
      $.ajax({
        url:"user_show.php",
        method:"POST",
        data: {id:user_id},
        success:function(data){
          let user_data = JSON.parse(data);

          //  managing Role with ID
          let role_status='';
          if(user_data.role=='Admin'){
            role_status = user_data.id+' &nbsp;&nbsp;&nbsp;&nbsp;(<span class="text-warning">'+user_data.role+'</span>)';
          }else{
            role_status = user_data.id+' &nbsp;&nbsp;&nbsp;&nbsp;(<span class="text-info">'+user_data.role+'</span>)';
          }
          $('#user_data_show_modal_id').html(role_status);

          //  managing Active or Inactive Status
          let name_status='';
          if(user_data.status=='Active'){
            name_status = user_data.name+' &nbsp;&nbsp;&nbsp;&nbsp;(<span class="text-success">'+user_data.status+'</span>)';
          }else{
            name_status = user_data.name+' &nbsp;&nbsp;&nbsp;&nbsp;(<span class="text-danger">'+user_data.status+'</span>)';
          }
          $('#user_data_show_modal_name').html(name_status);


          // Set All Datas in User Data Show Modal
          let photo_location = '../assets/uploaded_images/users/';
          $('#user_data_show_modal_img').attr('src',photo_location+user_data.photo);
          $('#user_data_show_modal_username').html(user_data.username);
          $('#user_data_show_modal_email').html(user_data.email);
          $('#user_data_show_modal_cell').html(user_data.cell);
          $('#user_data_show_modal_created_at').html(user_data.created_at);
        }
      });
      $('#user_data_show_modal').modal('show');
    });

    //  After Click on Edit button in User table
    $(document).on('click','#user_data_change',function(e){
      e.preventDefault();
      $('#user_data_change_modal_form_response_message').html('');
      let user_id = $(this).attr('user_id');
      $.ajax({
        url:"user_show.php",
        method:"POST",
        data: {id:user_id},
        success:function(data){
          let user_data = JSON.parse(data);
          $('#user_data_change_modal_form input[name="id"]').val(user_data.id);
          $('#user_data_change_modal_form input[name="name"]').val(user_data.name);
          $('#user_data_change_modal_form input[name="username"]').val(user_data.username);
          $('#user_data_change_modal_form input[name="email"]').val(user_data.email);
          $('#user_data_change_modal_form input[name="cell"]').val(user_data.cell);
          $('#user_data_change_modal_form select[name="role"]').val(user_data.role);
          $('#user_data_change_modal_form select[name="status"]').val(user_data.status);
        }
      });
      $('#user_data_change_modal').modal('show');
    });

    //  After Click on Delete button in User table
    $(document).on('click','#user_data_soft_delete',function(e){
      e.preventDefault();
      let user_id = $(this).attr('user_id');
      $.ajax({
        url:"user_soft_delete.php",
        method:"POST",
        data: {id:user_id},
        success:function(data){
          $('#user_moved_to_trash_message').html(data);
          view_all_Users();
        }
      });
    });

    //  After Click on restore button in User table in Deleted Users's List
    $(document).on('click','#user_data_restore',function(e){
      e.preventDefault();
      $('#user_delete_message').text('');
      $('#user_restore_message').text('');
      let user_id = $(this).attr('user_id');
      $.ajax({
        url:"user_restore.php",
        method:"POST",
        data: {id:user_id},
        success:function(data){
          $('#user_restore_message').html(data);
          view_all_Users();
        }
      });
    });

    //  After Click on Delete button in User table in Deleted Users's List
    $(document).on('click','#user_data_delete',function(e){
      e.preventDefault();
      $('#user_delete_message').text('');
      $('#user_restore_message').text('');
      let user_id = $(this).attr('user_id');
      let conf = confirm('This user will be Deleted Paermanently. Are you Sure ?');
      if(conf){
        $.ajax({
          url:"user_delete.php",
          method:"POST",
          data: {id:user_id},
          success:function(data){
            $('#user_delete_message').html(data);
            view_all_Users();
          }
        });
      }
    });

    //  After Clicking on User Edit Modal's Update Button
    $(document).on('submit','#user_data_change_modal_form',function(e){
      e.preventDefault();
      $.ajax({
        url:"user_edit.php",
        method:"POST",
        data: new FormData(this),
        contentType:false,
        processData:false,
        success:function(data){
          $('#user_data_change_modal_form_response_message').html(data);
          $('#user_data_change_modal_form input[name="password"]').val('');
          view_all_Users();
        }
      });
    });
  });

  // Photo Change
  $(document).on('change','#user_photo',function(e){
    let file_url = URL.createObjectURL(e.target.files[0]);
    $('img#user_photo_upload').attr('src',file_url);
  });

  // View All Datas Function
    function view_all_Users(){
      $.ajax({
        url: 'users_show.php',
        method: 'POST',
        success:function(data){
          $('#all_students_information').html(data);
        }
      });
      $.ajax({
        url: 'users_trash_show.php',
        method: 'POST',
        success:function(data){
          $('#all_deleted_students_information').html(data);
        }
      });
    }

})(jQuery)
