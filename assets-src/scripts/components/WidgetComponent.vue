<template>
  <section>
    <div class="columns">
      <div class="column">
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
              <label class="label">Widget Template</label>
              <div class="control">
                <codemirror v-model="widget.widget_template" :options="widgetTemplateOptions"/>
              </div>
            </div>
          </div>
        </div>
        <div class="columns">
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
        <b-button type="is-primary is-medium"
        v-on:click="updateWidget(
          widget.widget_provider,
          widget.widget_name,
          widget.widget_config,
          widget.widget_template,
          widget.widget_style,
          widget.widget_script
          )"
        expanded>Save</b-button>
      </div>
      <div class="column is-one-quarter">

      </div>
    </div>
  </section>
</template>

<script>
import 'codemirror/theme/monokai.css';
// eslint-disable-next-line import/extensions
import 'codemirror/mode/yaml/yaml.js';
// eslint-disable-next-line import/extensions
import 'codemirror/mode/htmlmixed/htmlmixed.js';
// eslint-disable-next-line import/extensions
import 'codemirror/mode/css/css.js';
// eslint-disable-next-line import/extensions
import 'codemirror/mode/javascript/javascript.js';

export default {
  data() {
    return {
      errors: [],
      widget: [],
      widgetCodeOptions: {
        indentWithTabs: true,
        tabSize: 2,
        indentUnit: 2,
        mode: 'yaml',
        theme: 'monokai',
        lineNumbers: true,
        line: true,
      },
      widgetTemplateOptions: {
        indentWithTabs: true,
        tabSize: 2,
        indentUnit: 2,
        mode: 'htmlmixed',
        theme: 'monokai',
        lineNumbers: true,
        line: true,
      },
      widgetStyleOptions: {
        indentWithTabs: true,
        tabSize: 2,
        indentUnit: 2,
        mode: 'css',
        theme: 'monokai',
        lineNumbers: true,
        line: true,
      },
      widgetScriptOptions: {
        indentWithTabs: true,
        tabSize: 2,
        indentUnit: 2,
        mode: 'javascript',
        theme: 'monokai',
        lineNumbers: true,
        line: true,
      },
    };
  },
  methods: {
    updateWidget(widgetProvider, widgetName, widgetConfig, widgetTemplate, widgetStyle, widgetScript) {
      window.axios
        .put(`${dataWpseedWidgetizerAdmin.restUrl}widgetizer/v1/widgets/${widgetProvider}/${widgetName}`, {
          params: {
            widget_config: widgetConfig,
            widget_template: widgetTemplate,
            widget_style: widgetStyle,
            widget_script: widgetScript,
          },
        })
        .then(
          (response) => {
            console.log(response.data);
            this.$buefy.toast.open({
              message: 'Widget updated',
              type: 'is-success',
            });
          },
        )
        .catch(
          (e) => { this.errors.push(e); },
        );
    },
  },
  computed: {},
  created() {
    window.axios
      .get(`${dataWpseedWidgetizerAdmin.restUrl}widgetizer/v1/widgets/${this.$route.params.widget_provider}/${this.$route.params.widget_name}`)
      .then(
        (response) => {
          this.widget = response.data;
        },
      )
      .catch(
        (e) => { this.errors.push(e); },
      );
  },
  mounted() {},
};
</script>
