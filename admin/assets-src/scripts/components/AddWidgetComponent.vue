<template>
    <section>
        <div class="columns">
            <div class="column">
                <b-field label="Widget Provider Title">
                    <b-input v-model="widget_provider"></b-input>
                </b-field>
                <b-field label="Widget Provider Slug">
                    <b-input :value="widget_provider_slug"></b-input>
                </b-field>
            </div>
            <div class="column">
                <b-field label="Widget Title">
                    <b-input v-model="widget_name"></b-input>
                </b-field>
                <b-field label="Widget Slug">
                    <b-input :value="widget_name_slug"></b-input>
                </b-field>
            </div>
            <div class="column">

            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Widget Config</label>
                    <div class="control">
                        <codemirror v-model="widget_code" :options="widgetCodeOptions"></codemirror>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Widget Style</label>
                    <div class="control">
                        <codemirror v-model="widget_style" :options="widgetStyleOptions"></codemirror>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Widget Script</label>
                    <div class="control">
                        <codemirror v-model="widget_script" :options="widgetScriptOptions"></codemirror>
                    </div>
                </div>
            </div>
        </div>
        <b-button type="is-primary is-medium" expanded  @click="addWidget">Save</b-button>
    </section>
</template>

<script>
    import 'codemirror/theme/monokai.css'
    import 'codemirror/mode/yaml/yaml.js'
    import 'codemirror/mode/css/css.js'
    import 'codemirror/mode/javascript/javascript.js'
    export default {
        data () {
            return {
                widget_provider: '',
                widget_name: '',
                widget_code: 'title: Hello World! # Widget title\n' +
                    'icon: eicon-testimonial # Widget icon',
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
            }
        },
        methods: {
            onCmReady(cm) {
                console.log('the editor is readied!', cm)
            },
            onCmFocus(cm) {
                console.log('the editor is focus!', cm)
            },
            onCmCodeChange(newCode) {
                console.log('this is new code', newCode)
                this.code = newCode
            },
            addWidget(){
                window.axios
                    .post(dataWpseedWidgetizerAdmin.restUrl + 'widgetizer/v1/widgets/'+ this.widget_provider_slug + '/' + this.widget_name_slug)
                    .then(
                        response => {
                            this.widget = response.data;
                            console.log(this.widget);
                        }
                    )
                    .catch(
                        e => { this.errors.push(e) }
                    )
            },
        },
        computed: {
            widget_provider_slug: function () {
                return window.slugify(this.widget_provider)
            },
            widget_name_slug: function () {
                return window.slugify(this.widget_name)
            },
        },
        mounted() {},
    }
</script>
