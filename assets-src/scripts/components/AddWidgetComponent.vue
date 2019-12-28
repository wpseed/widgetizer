<template>
    <section>
      <form @submit.prevent="submit">
        <div class="columns">
            <div class="column">
                <b-field label="Widget Provider Title" :type="{ 'is-danger': $v.widget_provider.$error }" :message="[
                { 'Field is required': $v.widget_provider.$error && !$v.widget_provider.required },
                { 'Field must have at least 4 letters': !$v.widget_provider.minLength }
                  ]">
                  <b-input v-model.trim="$v.widget_provider.$model" type="text"></b-input>
                </b-field>
                <b-field label="Widget Provider Slug" label-position="on-border">
                    <b-input custom-class="is-small" :value="widget_provider_slug"></b-input>
                </b-field>
            </div>
            <div class="column">
              <b-field label="Widget Name" :type="{ 'is-danger': $v.widget_name.$error }" :message="[
                { 'Field is required': $v.widget_name.$error && !$v.widget_name.required },
                { 'Field must have at least 4 letters': !$v.widget_name.minLength }
                  ]">
                <b-input v-model.trim="$v.widget_name.$model"></b-input>
              </b-field>
              <b-field label="Widget Name Slug" label-position="on-border">
                <b-input custom-class="is-small" :value="widget_name_slug"></b-input>
              </b-field>
            </div>
            <div class="column">

            </div>
        </div>
        <b-button type="is-primary is-medium" expanded  @click="createWidget">Save</b-button>
      </form>
    </section>
</template>

<script>
import { required, minLength, between } from 'vuelidate/lib/validators';
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
      widget_provider: '',
      widget_name: '',
      widget_code: 'title: Hello World! # Widget title\n'
                    + 'icon: eicon-testimonial # Widget icon',
      widget_style: '',
      widget_script: '',
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
      errors: [],
    };
  },
  methods: {
    createWidget() {
      console.log('submit!');
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.submitStatus = 'Invalid fields detected';
        console.log('Invalid fields detected');
      } else {
        window.axios
          .post(`${dataWpseedWidgetizerAdmin.restUrl}widgetizer/v1/widgets/${this.widget_provider_slug}/${this.widget_name_slug}`)
          .then(
            (response) => {
              this.widget = response.data;
              this.$buefy.toast.open({
                message: 'Widget created',
                type: 'is-success',
              });
              console.log(this.widget);
            },
          )
          .catch(
            (e) => {
              this.errors.push(e);
              this.$buefy.toast.open({
                message: e.response.data.message,
                type: 'is-danger',
              });
            },
          );
        this.submitStatus = 'PENDING';
        setTimeout(() => {
          this.submitStatus = 'OK';
        }, 500);
      }
    },
  },
  computed: {
    widget_provider_slug() {
      return window.slugify(this.widget_provider);
    },
    widget_name_slug() {
      return window.slugify(this.widget_name);
    },
  },
  mounted() {},
  validations: {
    widget_provider: {
      required,
      minLength: minLength(4),
    },
    widget_name: {
      required,
      minLength: minLength(4),
    },
  },
};
</script>
