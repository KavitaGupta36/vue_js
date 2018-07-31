<template>
   <div>
     <div class="container">
         <div class="row justify-content-center">
             <div class="col-md-8">
                 <div class="card card-default">
                     <div class="card-header">User Records</div>
                     
                    <button @click="initAddTask()" class="btn btn-primary btn-xs pull-right"> + Add New Task</button>

                    <div class="modal fade" role="dialog" id="add_task_model">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                          aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Add New Task</h4>
                              </div>
                              <div class="modal-body">
                                  <div class="alert alert-danger" v-if="errors.length > 0">
                                      <ul>
                                          <li v-for="error in errors">{{ error }}</li>
                                      </ul>
                                  </div>
                                  <div class="form-group">
                                      <label for="name">Name:</label>
                                      <input type="text" name="name" placeholder="User Name" v-model="user.user_name" class="form-control">
                                  </div>
                                  <div class="form-group">
                                      <label for="description">Email:</label>
                                      <input type="email" name="email" cols="30" rows="5" class="form-control" v-model="user.email"
                                                placeholder="Email" >
                                  </div>
                                  <div class="form-group">
                                      <label for="description">Password:</label>
                                      <input type="password" name="password" cols="30" rows="5" class="form-control" v-model="user.password" placeholder="Password" >
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  <button type="button" @click="createTask" class="btn btn-primary">Submit</button>
                              </div>
                          </div>
                        </div>
                    </div>

                      <table>
                        <tr>
                            <th>Id.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        <tr v-for = "(task, index) in tasks.data">
                            <td>{{index}}</td>
                            <td>{{task.name}}</td>
                            <td>{{task.email}}</td>
                            <td>
                                <button @click = "initUpdate(index)" class="btn btn-success btn-xs">Edit</button>
                                <button @click="deleteTask(index)" class="btn btn-danger btn-xs">Delete</button>
                            </td>
                        </tr>
          <pagination :data="tasks" @pagination-change-page="getResults"></pagination>
                     </table>
                 </div>
             </div>
         </div>
         <!--for update modal-->
         <div class="modal fade" role="dialog" id="update_task_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Task</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" placeholder="Task Name" class="form-control"
                                   v-model="update_task.name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea cols="30" rows="5" class="form-control"
                                      placeholder="Task Description" v-model="update_task.email"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateTask" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->  
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
     </div>
   </div>
</template>
<script>
  export default {
    data() {
        return {
          user: {
            user_name: '',
            email: '',
            password: ''
          },
          errors: [],
          tasks : {},
          update_task: {}
        }
      },
      methods: {
        initAddTask()
        {
            $("#add_task_model").modal("show");
        },
        getResults(page)
        {
            if (typeof page === 'undefined') {
                page = 1;
            }
            console.log('page')
            let this_ = this;
            axios.get('/getList?page=' + page)
                .then(response => {
                    console.log(response.data)
                    this_.tasks = response.data
                });
        },
        createTask() {
            var app = this;
            var postData = app.user;
            console.log(postData)

                axios.post('/SubForm',postData)
                    .then(response => {
                        $("#add_task_model").modal("hide");
                        console.log(response)
                    })
                    .catch(error => {
                        this.errors = [];
                        console.log(error)
                        if (error.response.data.errors.user_name) {
                            this.errors.push(error.response.data.errors.user_name[0]);
                        }
                        if (error.response.data.errors.email) {
                            this.errors.push(error.response.data.errors.email[0]);
                        }
                    });
            },
            initUpdate(index)
            {
                $("#update_task_model").modal("show");
                this.update_task = this.tasks[index];
            },
            updateTask()
            {
                axios.post('/update/' + this.update_task.id, {
                    user_name: this.update_task.name,
                    email: this.update_task.email,
                })
                .then(response => {
                    console.log(response)
                    $("#update_task_model").modal("hide");
                })
            },
            deleteTask(index)
            {
                let conf = confirm("Do you ready want to delete this task?");
                if (conf === true) {
                    axios.post('/delete/' + this.tasks[index].id)
                        .then(response => {
                            this.tasks.splice(index, 1);
                        })
                }
            }
        },
        mounted(){
          this.getResults();
            /*let this_ = this;
            axios.get('/getList')
                .then(response => {
                    console.log(response.data)
                    this_.tasks = response.data.data;
                    this_.pagination.current_page = response.data.current_page
                    this_.pagination.last_page = response.data.last_page
                });*/
        }
  }
</script>
