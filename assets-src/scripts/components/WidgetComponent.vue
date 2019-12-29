<template>
    <section>
        <div class="columns">
          <div class="column">
            <div class="field">
              <label class="label">Widget Name</label>
              <div class="control">{{ widget.widget_name }}</div>
            </div>
            <div class="field">
              <label class="label">Widget Provider</label>
              <div class="control">{{ widget.widget_provider }}</div>
            </div>
          </div>
          <div class="column">
          </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Widget Config</label>
                    <div class="control">
                      <codemirror v-model="widget.widget_config" :options="widgetCodeOptions"/>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Widget Style</label>
                    <div class="control">
                      <codemirror v-model="widget.widget_style" :options="widgetStyleOptions"/>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Widget Script</label>
                    <div class="control">
                      <codemirror v-model="widget.widget_script" :options="widgetScriptOptions"/>
                    </div>
                </div>
            </div>
        </div>
        <b-button type="is-primary is-medium" v-on:click="updateWidget(widget.widget_provider, widget.widget_name)" expanded>Save</b-button>
    </section>
</template>

<script>
import 'codemirror/theme/monokai.css';
// eslint-disable-next-line import/extensions
import 'codemirror/mode/yaml/yaml.js';
// eslint-disable-next-line import/extensions
import 'codemirror/mode/css/css.js';
// eslint-disable-next-line import/extensions
import 'codemirror/mode/javascript/javascript.js';

export default {
  data() {
    return {
      widget: [],
      widgetCodeOptions: {
        tabSize: 2,
        mode: 'yaml',
        theme: 'monokai',
        lineNumbers: true,
        line: true,
      },
      widgetStyleOptions: {
        tabSize: 2,
        mode: 'css',
        theme: 'monokai',
        lineNumbers: true,
        line: true,
      },
      widgetScriptOptions: {
        tabSize: 2,
        mode: 'javascript',
        theme: 'monokai',
        lineNumbers: true,
        line: true,
      },
    };
  },
  methods: {
    updateWidget(provider, name) {
      window.axios
        .patch(`${dataWpseedWidgetizerAdmin.restUrl}widgetizer/v1/widgets/${provider}/${name}`)
        .then(
          (response) => {
            this.$buefy.toast.open({
              message: 'Widget updated',
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
    },
  },
  computed: {},
  created() {
    window.axios
      .get(`${dataWpseedWidgetizerAdmin.restUrl}widgetizer/v1/widgets/${this.$route.params.widget_provider}/${this.$route.params.widget_name}`)
      .then(
        (response) => {
          this.widget = response.data;
          console.log(this.widget);
        },
      )
      .catch(
        (e) => { this.errors.push(e); },
      );
  },
  mounted() {},
};
</script>
