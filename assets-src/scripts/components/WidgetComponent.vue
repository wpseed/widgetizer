<template>
    <section>
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
        <b-button type="is-primary is-medium" expanded>Save</b-button>
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
                widget_code: 'text: text',
                widget_style: 'style',
                widget_script: 'script',
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
            }
        },
        computed: {},
        created() {
            window.axios
                .get(dataWpseedWidgetizerAdmin.restUrl + 'widgetizer/v1/widgets/' + this.$route.params.provider + '/' + this.$route.params.widget_name)
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
        mounted() {}
    }
</script>
