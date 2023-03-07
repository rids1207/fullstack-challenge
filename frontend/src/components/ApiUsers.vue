<template>
  <div>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Weather</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ JSON.parse(user.user_weather.weather_data).main.temp }}&#8451</td>
          <td><button class="view-etails" @click="showPopup(user)">View Details</button></td>
        </tr>
        <tr v-if="users.length === 0">
          <td colspan="4">User not found</td>
        </tr>
      </tbody>
    </table>
  </div>
  <Modal :show="showModal" @close="hidePopup" :user="popupUser" />
</template>
  
<script lang="ts">
import axios from 'axios';
import Modal from './Modal.vue';

export default {
  name: 'WeatherTable',
  components: {
    Modal
  },
  data() {
    return {
      users: [],
      popupUser: null,
      showModal: false,
    };
  },
  created() {
    this.getUsersData();
  },
  methods: {
    async getUsersData() {
      try {
        const response = await axios.get('http://localhost/fullstack-challenge/api/public/users');
        var users = response.data;
        this.users = users.userData;
      } catch (error) {
        console.error(error);
      }
    },
    showPopup(user) {
      this.popupUser = user;
      this.showModal = true;
    },
    hidePopup() {
      this.popupUser = null;
      this.showModal = false;
    },
  },
};
</script>
  
<style>
.modal {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}


.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
 
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.view-etails{
    background: transparent;
    border: 1px solid;
    padding: 8px;
}
.view-etails:hover{
    background: #000;
    color:#fff;
    cursor:pointer;
}

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td,
th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

</style>
  