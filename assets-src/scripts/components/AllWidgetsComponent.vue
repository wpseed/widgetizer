<template>
  <section>
    <b-table
      :data="widgets"
      :paginated=true
      :per-page=10
      :pagination-simple=false>
      <template slot-scope="props">
        <b-table-column field="widget_name" label="Widget Name" :id="props.row.id" sortable searchable>
          <router-link :to="'/widgets/' + props.row.widget_provider + '/' + props.row.widget_name">
            {{ props.row.widget_name }}
          </router-link>
        </b-table-column>
        <b-table-column field="widget_provider" label="Widget Provider" sortable searchable>
          {{ props.row.widget_provider }}
        </b-table-column>
        <b-table-column field="widget_actions" label="" width="220">
          <div class="buttons">
            <b-button type="is-success" icon-left="content-copy"
              v-on:click="duplicateWidget(props.row.widget_provider, props.row.widget_name)">
              Duplicate
            </b-button>
            <b-button type="is-danger" icon-left="delete" v-if="props.row.widget_provider !== 'widgetizer'"
              v-on:click="deleteWidget(props.row.id, props.row.widget_provider, props.row.widget_name)">
              Delete
            </b-button>
          </div>
        </b-table-column>
      </template>
    </b-table>
  </section>
</template>

<script>
export default {
  data() {
    return {
      widgets: [],
      errors: [],
      dataWpseedWidgetizerAdmin: window.dataWpseedWidgetizerAdmin,
    };
  },
  methods: {
    duplicateWidget(provider, name) {
      console.log([provider, name]);
    },
    deleteWidget(id, provider, name) {
      this.$buefy.dialog.confirm({
        title: 'Deleting widget',
        message: 'Are you sure you want to <b>delete</b> widget? This action cannot be undone.',
        confirmText: 'Delete Widget',
        type: 'is-danger',
        hasIcon: true,
        onConfirm: () => {
          window.axios
            .delete(`${dataWpseedWidgetizerAdmin.restUrl}widgetizer/v1/widgets/${provider}/${name}`)
            .then(
              (response) => {
                this.$data.widgets.splice(id, 1);
                this.$buefy.toast.open({
                  message: 'Widget deleted',
                  type: 'is-success',
                });
                console.log(index);
              },
            )
            .catch(
              (e) => {
                this.errors.push(e);
              },
            );
          console.log([provider, name]);
        }
      });
    },
  },
  created() {
    window.axios
      .get(`${dataWpseedWidgetizerAdmin.restUrl}widgetizer/v1/widgets/`)
      .then(
        (response) => {
          this.widgets = response.data;
          console.log(this.widgets);
        },
      )
      .catch(
        (e) => {
          this.errors.push(e);
        },
      );
  },
};
</script>
