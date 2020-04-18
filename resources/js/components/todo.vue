<template>
  <div class="w-50 m-5">
    <div class="w-100 d-flex">
      <input
        class="c-input-text w-100 m-2 rounded p-2 bg-dark text-white"
        placeholder="New Todo"
        type="text"
        @keyup.enter="submitTodo()"
        v-model="todo.body"
        v-autofocus
      />
      <input
        class="c-btn rounded btn-primary m-2 px-3 py-1"
        type="submit"
        value="Submit"
        @click="submitTodo()"
      />
    </div>
    <div class="d-flex">
      <a
        class="c-todo-heading c-btn-l text-center text-white w-50 my-1 mx-2 py-1 rounded"
        :class="{'btn-primary': currentTodos}"
        @click="viewTodos(true)"
      >Todos</a>
      <a
        class="c-todo-heading c-btn-l text-center text-white w-50 my-1 mx-2 py-1 rounded"
        :class="{'btn-primary': !currentTodos}"
        @click="viewTodos(false)"
      >Archive</a>
    </div>
    <ul
      class="d-flex justify-content-center align-items-center flex-wrap border rounded m-2 p-2 list-unstyled"
    >
      <li
        class="d-flex w-100 border border-left-0 border-top-0 border-right-0 border-secondary p-2"
        v-for="todo in list"
        :key="todo.id"
      >
        <div class="w-100">
          <input
            class="checkbox m-2"
            type="checkbox"
            :checked="!currentTodos"
            @click="changeArchive(todo)"
          />
          <p
            class="w-100 p-2 c-list-text c-todo-text d-inline text-white"
            v-if="todo.id !== editableTodo"
            @click="inputOn(todo.id)"
            :class="{'text-muted text-secondary c-line-through': !currentTodos}"
          >{{todo.body}}</p>
          <div class="d-inline" v-if="todo.id === editableTodo">
            <input class="c-input-text rounded bg-dark text-white" v-autofocus type="text" v-model="todo.body" @keyup.esc="displayOn()" @blur="displayOn()"/>
            <input
              class="c-link-text btn-outline-primary rounded bg-dark"
              type="submit"
              value="Submit"
              @click="changeBody(todo); displayOn()"
            />
          </div>
        </div>
        <div>
          <button class="c-link-text btn-primary rounded" @click="deleteTodo(todo.id)">Delete</button>
        </div>
      </li>
      <p class="c-list-text text-secondary m-0" v-if="list.length < 1">Nothing to show... yet</p>
    </ul>
  </div>
</template>

<style lang="scss" scoped>
.todo-item {
  display: inline;
}
.c-todo-heading {
  cursor: pointer;
}
.c-todo-text {
  &:hover {
    text-decoration: underline;
    cursor: pointer;
  }
}
</style>

<script>
export default {
  data: function() {
    return {
      list: [],
      todo: {
        id: "",
        body: "",
        archive: 0
      },
      editableTodo: "",
      currentTodos: true
    };
  },
  created: function() {
    this.getTodo();
  },
  methods: {
    viewTodos: function(value) {
      this.currentTodos = value;
      this.getTodo();
    },
    inputOn: function(id) {
      this.editableTodo = id;
    },
    displayOn: function() {
      this.editableTodo = "";
    },
    getTodo: function() {
      if (this.currentTodos === true) {
        this.todo = {};
        axios
          .get("todo_data")
          .then(response => {
            //arrow function because with keyword "function" the scope of "this" is limited only to it;
            this.list = response.data;
          })
          .catch(function(error) {
            console.log(error);
          });
      } else {
        axios
          .get("archive_data")
          .then(response => {
            this.list = response.data;
          })
          .catch(function(error) {
            console.log(error);
          });
      }
    },
    submitTodo: function() {
      let value = { body: this.todo.body };
      axios.post("create_todo", value).then(response => {
        this.currentTodos = true;
        this.getTodo();
        this.todo = {};
      })
       .catch(function(error) {
            console.log(error);
          });
    },
    changeArchive: function(todo) {
      this.todo = todo;
      this.todo.archive = !this.todo.archive;
      this.updateTodo(this.todo.id);
    },
    changeBody: function(todo) {
      this.todo = todo;
      this.updateTodo(this.todo.id);
    },
    updateTodo: function(id) {
      axios
        .post("update_todo/" + id, this.todo)
        .then(response => {
          this.getTodo();
        })
        .catch(function(error) {
          console.log(error);
        });
      this.todo = {};
    },
    deleteTodo: function(id) {
      axios.post("delete_todo/" + id).then(response => {
        this.getTodo();
      });
    }
  }
};
</script>
