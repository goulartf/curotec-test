<template>
    <div class="container py-3">
        <h1>Tasks <span class="text-small">( {{ tasks.length }} )</span></h1>
        <div class="input-group py-3 mb-3">
            <input type="text"
                   class="form-control"
                   @input="handleInput"
                   :value="newTask"
                   placeholder="New Task">
            <div class="input-group-prepend">
                <button class="btn btn-primary" type="button" @click="addTask">+ Add</button>
            </div>
        </div>
        <div class="py-3">
            <div v-if="loading" class="text-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-else v-for="(task, index) in tasks" class="input-group mb-3" :key="index">
                <div :class="task.completed ? 'bg-success' : 'bg-secondary'"
                     class="d-flex justify-content-between align-items-center my-alert w-96"
                     @click="completedTask(task)">
                    <p :class="task.completed? 'text-completed' : ''">{{ task.title }}</p>
                </div>
                <div class="w-4">
                    <button class="btn btn-danger" type="button" @click="deleteTask(task)">X</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";

const API_URL = 'http://localhost:8000/api/tasks';

export default {
    name: 'App',
    data() {
        return {
            tasks: [],
            newTask: '',
            loading: true
        }
    },
    components: {},
    async mounted() {
        const response = await axios.get(API_URL)
        this.tasks = response.data.data;
        this.loading = false
    },
    methods: {
        handleInput(event) {
            this.newTask = event.target.value;
        },
        async addTask() {
            this.loading = true
            const response = await axios.post(API_URL, {title: this.newTask})

            const task = response.data.data;
            this.tasks.push(task)
            this.newTask = ''
            this.loading = false
        },
        deleteTask(task) {
            this.loading = true
            this.tasks = this.tasks.filter(_task => _task.id !== task.id)
            if ('tempId' in task) {
                return;
            }
            axios.delete(`${API_URL}/${task.id}`)

            this.loading = false
        },
        completedTask(task) {
            this.loading = true
            const isCompleted = !task.completed;
            this.tasks.map(_task => {
                if (task === _task) {
                    _task.completed = isCompleted;
                }

                return _task;
            });

            axios.put(`${API_URL}/${task.id}`, {completed: isCompleted})
            this.loading = false
        },
    }
}
</script>

<style>
.w-96 {
    width: 96%;
}

.w-4 {
    width: 4%;
}

.my-alert p {
    margin-bottom: 0;
    padding-left: 10px;
}

.text-completed {
    text-decoration: line-through;
}

.btn {
    border-radius: 0;
}

.text-small {
    font-size: 1.8rem;
    color: #c0c0c0;
}

</style>
