<template>
    <div>
        <div class="card mb-5">
            <div class="card-header d-flex justify-content-between bd-highlight">
                <div>Task Lists</div>
                <button @click="openModal" type="button" class="btn btn-primary btn-sm">Create Task</button>
            </div>
            <div class="card-body">
                <select v-model="form.projectId" @click="loadTask" class="form-control form-control-sm mb-5">
                    <option value="" disabled selected>Choose Project to see their TASKS</option>
                    <option v-for="project in projects" :key="project.id" v-bind:value="project.id" >{{project.title}}</option>
                </select>

                <draggable :list="tasks" :options="{animation:300}" :element="'div'">
                    <div v-for="(task) in tasks" :key="task.id" class="d-flex cursor">
                        <div v-if="!task.editing" @dblclick="editTask(task)" class="form-control mb-2 task-content"> {{task.title}}</div>
                        <textarea v-else type="text" cols="5" rows="5" class="form-control mb-2"
                            v-model="form.title" @blur="doneEdit(task)" @keyup.enter="doneEdit(task)" v-focus @keyup.esc="cancelEdit(task)"></textarea>
                        <div class="remove-item" @click="removeTask(task)" >&times;</div>
                    </div>
                </draggable>
            </div>
        </div>

        <!-- modal -->
        <div class="modal" id="AddNew" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <select  v-model="form.projectId" class="form-control form-control-sm mb-5">
                            <option value="" disabled selected>Choose Project you want to assign task to</option>
                            <option v-for="project in projects" :key="project.id" v-bind:value="project.id">{{project.title}}</option>
                        </select>
                        <textarea  v-model="form.title" class="form-control" name="" id="" cols="5" rows="5"></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button @click="createTask()" type="button" class="btn btn-primary">Add Task</button>
                </div>
                </div>
            </div>
        </div>
        <!-- end modal -->
    </div>
</template>

<script>
    export default {
         data(){
            return{
                form: new Form({
                    id:'',
                    projectId:'',                   
                    title: '',
                    editing: false
                 }),
                projects: {},
                tasks: []
            }
        },

        directives: {
            focus: {
                inserted: function (el){
                    el.focus()
                }
            }
        },
        methods:{
            getTaskByProject(){
                this.form.post('api/task').then(() =>{
                    console.log(this.form.projectId)
                }).catch((error) =>{
                    console.log(error)
                })
            },
             loadProjects(){
                axios.get("api/project").then(({ data })=> (this.projects = data));
            },
            loadTask(){
                axios.get("api/task").then(({ data })=> (this.tasks = data));
            },            
            createTask(){
               if(this.form.title == ''){
                    return
                }
                this.form.post('api/task').then(() =>{
                    this.loadTask()
                }).catch((error) =>{
                    console.log(error)
                })
                this.form.reset();
                $('#AddNew').modal('hide')
            },
            removeTask(task){
               axios.delete('api/task/'+task.id).then((response) => { 
                    this.loadTask();                    
                    console.log(response)                 
                }).catch((error)=>{
                   console.log(error)
                })
            },
            editTask(task){
                this.beforeEditCache = this.form.fill(task);
                task.editing = true
            },
            cancelEdit(task){
                this.form.title = this.beforeEditCache
                task.editing = false
            },
            doneEdit(task){
                if(task.title.trim() == ''){
                   task.title = this.beforeEditCache
                }
                this.form.put('api/task/'+task.id).then(() =>{
                    this.loadTask()
                }).catch((error) =>{
                    console.log(error)
                })
                task.editing = false
            },
            openModal(){
                $('#AddNew').modal('show')
            }
        },
        created(){
            this. loadProjects()
            this.loadTask()
        }
    }
</script>