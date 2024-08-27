<template>
  <div class="settings-page">
    <h4>Settings</h4>
    <form method="post" @submit.prevent="onSubmit">
      <div class="form-group">
        <label for="row">Number of Row</label>
        <BaseInput
          :name="rownumber"
          type="number"
          :value="numrows"
          :min="1"
          :max="5"
          :on-change="onNumRowsChange"
        />
      </div>
      <div class="form-group">
        <label for="readable">Readable Date</label>
        <BaseInput
          v-if="isCheckbox"
          :name="checkboxName"
          :type="checkboxType"
          :value="checkboxValue"
          :placeholder="checkboxPlaceholder"
          :on-change="onCheckboxChange"
        />
      </div>
      <div class="form-group">
        <label>Emails (1-5):</label>
        <div class="email-group">
        <div v-for="(email, index) in emails" :key="index" class="email-input">
          <BaseInput
            :name="'email[' + index +']'"
            type="email"
            :value="email"
            required
            placeholder="email@example.com"
            :on-change="(value) => onEmailChange(index, value)"
          />
          <button v-if="emails.length > 1" class="remove-button" @click.prevent="removeEmail(index)">Remove</button>
        </div>
        </div>
        <button v-if="emails.length < 5" class="add-button" @click.prevent="addEmail">Add Email</button>
      </div>
      <Button type="submit">Save</Button>
      <div v-if="showMessage" :class="['message', messageType]">{{ message }}</div>
    </form>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Button from "../components/button/Button.vue";
import BaseInput from "../components/input/BaseInput.vue";

export default {
    name: "Settings",
    components: { Button, BaseInput },
    data() {
        return {
            wpAmVue: wpAmVue,
            rownumber: "rownumber",
            numrows: 5,
            checkboxName: "toggleSwitch",
            checkboxType: "checkbox",
            checkboxValue: 1,
            checkboxPlaceholder: "Toggle Switch",
            emails: [],
            showMessage: false,
            message: '',
            messageType: 'success', // 'success' or 'error'
        };
    },
    computed: {
        ...mapGetters([ "isSaving", "settings" ]),
        isCheckbox() {
            return this.checkboxType === "checkbox";
        },
    },
    watch: {
        settings: function() {
            this.populateFormFields();
        },
    },
    mounted() {
        this.getSettings();
    },
    methods: {
        ...mapActions([ "storeSettings", "getSettings" ]),
        async onSubmit(e) {
          e.preventDefault();
          // Validate email fields.
          if (this.emails.some(email => email.trim() === "")) {
                this.messageType = "error";
                this.message = "Email fields cannot be empty.";
                this.showMessage = true;
                return;
            }
            const setting = {
                rows: parseInt(this.numrows),
                readable: this.checkboxValue,
                emails: this.emails.map((email) => email),
            };
            try {
                await this.storeSettings(setting);
                this.messageType = 'success';
                this.message = 'Settings saved successfully!';
                this.showMessage = true;
                // Update local data with store getters
                this.populateFormFields();
            } catch (error) {
                this.messageType = 'error';
                this.message = 'Failed to save settings.';
                this.showMessage = true;
            }
            setTimeout(() => {
                this.showMessage = false;
            }, 5000);
        },
        onNumRowsChange(input) {
            this.numrows = input.value;
        },
        onCheckboxChange(data) {
            this.checkboxValue = data.value;
        },
        onEmailChange(index, input) {
            this.emails[index] = input.value;
        },
        removeEmail(index) {
            this.emails = this.emails.filter((email, i) => i !== index);
        },
        addEmail() {
            if (this.emails.length < 5) {
                this.emails = [ ...this.emails, "" ];
            }
        },
        populateFormFields() {
            this.numrows = this.settings.rows || 5;
            this.checkboxValue = this.settings.readable ? 1 : 0;
            this.emails = this.settings.emails || [this.wpAmVue.user.email];
        },
    },
};
</script>

<style lang="scss" scoped>
.message {
  margin-top: 20px;
  padding: 10px;
  border-radius: 4px;
  font-weight: bold;
  &.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
  }
  &.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
  }
}
form {
  .form-group {
    display: flex;
    align-items: flex-start;
    margin-bottom: 30px;
    padding-top:20px;
    label {
      margin-right: 100px;
      font-weight: bold;
      font-size: 16px;
      min-width: 150px;
    }
  }
  .email-group {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    .email-input {
      display: flex;
      gap: 10px;
      margin-bottom:15px
    }
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
