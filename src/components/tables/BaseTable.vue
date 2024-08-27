<template>
  <div class="table-responsive">
    <TableLoading v-if="loading" />
    <table v-if="!loading" class="base-table">
      <thead>
        <tr>
          <th v-for="header in headers" :key="header">{{ header }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in rows" :key="row.id">
          <td v-for="key in headers" :key="key">
            <div v-if="isHtml(key?.toLowerCase())" v-html="row?.[key?.toLowerCase()]" />
            <span v-else>{{ row?.[key?.toLowerCase()] }}</span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import TableLoading from './TableLoading.vue';

export default {
  name: 'BaseTable',
  components: {
    TableLoading,
  },
  props: {
    headers: {
      type: Array,
      required: true,
    },
    rows: {
      type: Array,
      required: true,
    },
    loading: {
      type: Boolean,
      required: false,
      default: false,
    },
    htmlColumns: {
      type: Array,
      required: false,
      default: () => [],
    }
  },
  computed: {
    ...mapGetters(["settings"]),
  },
  methods: {
    isHtml(keyName) {
      return this.htmlColumns.includes(keyName);
    }
  }
};
</script>

<style lang="scss" scoped>
.table-responsive {
  overflow-x: auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

  table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #8080801a;

    th, td {
      padding: 1rem;
      border-bottom: 1px solid #eee;
      text-align: left;
    }

    th {
      background-color: #0073aa;
      color: white;
      text-transform: uppercase;
      font-weight: bold;
    }

    td {
      background-color: white;
      color: #333;
    }

    tr:hover td {
      background-color: #f1f1f1;
    }
  }
}
</style>
