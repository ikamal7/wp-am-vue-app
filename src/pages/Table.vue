<template>
  <div class="table-page">
    <h4>Table Page</h4>
    <BaseTable :headers="tableHeaders" :rows="tableRows" />
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import BaseTable from '../components/tables/BaseTable.vue';
export default {
  name: "Table",

  components: {
    BaseTable
  },

  computed: {
    ...mapGetters({
      tableHeaders: "getTableHeaders",
      tableRows: "getTableRows",
      settings: "settings"
    }),
  },
  methods: {
    ...mapActions(["getTableData"]),
  },
  mounted() {
    // Dispatch the getTableData action when the component is mounted
    this.getTableData();
  },
};
</script>