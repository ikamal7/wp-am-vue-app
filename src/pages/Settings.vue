<template>
  <div class="settings-page">
    <h4>Settings</h4>
    <form @submit.prevent="onSubmit" method="post">
      <label for="row">Number of Row</label>
      <BaseInput
        :name="rownumber"
        type="number"
        :value="numrows"
        :min="1"
        :max="5"
        :on-change="onNumRowsChange"
      />

      <br />
      <label for="readable">Readble Date</label>
      <BaseInput
        v-if="isCheckbox"
        :name="checkboxName"
        :type="checkboxType"
        :value="checkboxValue"
        :placeholder="checkboxPlaceholder"
        :on-change="onCheckboxChange" />

      <br />
      <div style="margin-bottom: 30px;">
        <label>Emails (1-5):</label>
        <div class="inline-input" v-for="(email, index) in emails" :key="index">
          <BaseInput
            :name="'email[' + index +']'"
            type="email"
            :value="email"
            placeholder="email@example.com"
            :on-change="(value) => onEmailChange(index, value)" />

          <button
            @click.prevent="removeEmail(index)"
            v-if="emails.length > 1"
            class="remove-button">
            Remove
            </button>
        </div>
        <button
          @click.prevent="addEmail"
          class="add-button"
          v-if="emails.length < 5">
          Add
          Email
          </button>
      </div>

      <Button type="submit">Save</Button>
    </form>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Button from "../components/button/Button.vue";
import BaseInput from "../components/input/BaseInput.vue";

export default {
  name: "Settings",

  components: {
    Button,
    BaseInput,
  },

  data () {
    return {
      wpAmVue: wpAmVue,
      rownumber: "rownumber",
      numrows: 5,
      checkboxName: "toggleSwitch",
      checkboxType: "checkbox", // Set the type to "checkbox"
      checkboxValue: 1, // Set the initial value for the checkbox
      checkboxPlaceholder: "Toggle Switch",
      emails: [],
    };
  },

  mounted () {
    // Initialize with the default WordPress admin email
    this.emails.push(this.wpAmVue.user.email);
    this.getSettings();
  },

  computed: {
    ...mapGetters([ "isSaving", "settings" ]),
    isCheckbox () {
      return this.checkboxType === "checkbox";
    },
  },

  methods: {
    ...mapActions([ "storeSettings", "getSettings" ]),
    onSubmit (e) {
      e.preventDefault();

      const setting = {
        rows: parseInt(this.numrows),
        readable: this.checkboxValue,
        emails: this.emails.map((email) => email),
      };

      this.storeSettings(setting);
    },

    onNumRowsChange(input) {
      // Update the numrows property when the input value changes
      this.numrows = input.value;
    },

    onCheckboxChange (data) {
      // Handle checkbox change
     this.checkboxValue = data.value;
    },

    onEmailChange (index, input) {
      this.emails[index] = input.value;
    },
    removeEmail (index) {
      // Create a new array without the email field at the given index
      this.emails = this.emails.filter((email, i) => i !== index);
    },

    addEmail () {
      // Add a new email field if the limit is not reached
      if (this.emails.length < 5) {
        this.emails = [ ...this.emails, "" ];
      }
    },
    populateFormFields() {
      this.numrows = this.settings.rows || 5;
      this.checkboxValue = this.settings.readable ? 1 : 0;
      this.emails = this.settings.emails || [];
    },
  },

  watch: {
    settings: function () {
      // console.log("Vuex state settings::", this.settings);
      this.populateFormFields();
    },
  },
};
</script>

<style lang="scss" scoped>
form {
  label {
    display: inline-block;
    margin-bottom: 10px;
  }
}

.inline-input {
  display: flex;
  justify-items: center;
  gap: 10px;
  max-width: 400px;
  margin-bottom: 20px;
}

.remove-button {
  background: #f04;
  color: #fff;
  border: 0px solid;
  padding: 10px 20px;
  cursor: pointer;
  transition: all;
  border-radius: 4px;

  &:hover {
    opacity: 0.9;
  }
}

.add-button {
  background: #367830;
  color: #fff;
  border: 0px solid;
  padding: 10px 20px;
  cursor: pointer;
  transition: all;
  border-radius: 4px;

  &:hover {
    opacity: 0.9;
  }
}
</style>