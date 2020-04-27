<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <task-component></task-component>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Projects Lists</div>
                    <div class="card-body">
                        <input type="text" v-if="!this.form.editing" class="form-control" placeholder="Enter Project Title, Press Enter Key"
                            v-model="form.title" @keyup.enter="createProject" :class="{ 'is-invalid': form.errors.has('title') }">
                       <has-error :form="form" field="title"></has-error>
                        <div class="mb-5"></div>
                        <draggable :list="projects" :options="{animation:200}" :element="'div'">
                            <div v-for="(project) in projects" :key="project.id" class="d-flex cursor">
                                <div v-if="!project.editing" @dblclick="editProject(project)" class="form-control form-control-md mb-2">{{project.title}}</div>
                                <input v-else type="text" class="form-control form-control-md mb-2" placeholder="Edit Project" 
                                v-model="form.title" @blur="doneEdit(project)" @keyup.enter="doneEdit(project)" v-focus @keyup.esc="cancelEdit(project)" >
                                <div class="remove-item" @click="removeProject(project)">&times;</div>
                            </div>
                        </draggable>
                     </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
         data(){
            return{
                idforProject: 4,
                beforeEditCache: '',
                 form: new Form({
                    id:'',                   
                    title: '',
                    editing: false
                 }),
                projects: {}
            }
        },
        directives: {
            focus: {
                inserted: function (el){
                    el.focus()
                }
            }
        },
        methods: {
            loadProjects(){
                axios.get("api/project").then(({ data })=> (this.projects = data));
            },
            createProject(){
                if(this.form.title == ''){
                    return
                }
                this.form.post('api/project').then(() =>{
                    this.loadProjects();
                }).catch((error) =>{
                    console.log(error)
                })
                this.form.reset();
            },
            removeProject(project){
               axios.delete('api/project/'+project.id).then((response) => { 
                    this.loadProjects();                    
                    console.log(response)                 
                }).catch((error)=>{
                   console.log(error)
                })
            },
            editProject(project){
                this.beforeEditCache = this.form.fill(project);
                project.editing = true
                this.form.editing = true
            },
            cancelEdit(project){
                 if(this.form.title == ''){
                    this.form.title = this.beforeEditCache
                    return
                }
                project.title = this.beforeEditCache
                project.editing = false
                this.form.editing = false

                this.form.reset();
                this.loadProjects();
            },
            doneEdit(project){
                if(project.title == ''){
                   project.title = this.beforeEditCache
                   return
                }
                this.form.put('api/project/'+project.id)
                project.editing = false
                this.form.editing = false

                this.form.reset();
                this.loadProjects();
            },
        },

        created(){
                this.loadProjects();
                // Fire.$on('afterCreated', () => { this.loadShippments(); })
                // setInterval(() => this.loadProjects(), 3000);
            }
    }
</script>

