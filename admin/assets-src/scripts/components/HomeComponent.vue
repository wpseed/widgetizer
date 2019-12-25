<template>
    <section>
        <b-table
                :data="widgets"
                :columns="columns"
                :paginated=true
                :per-page=10
                :pagination-simple=false>
            <template slot-scope="props">
                <b-table-column field="widget_name" label="Widget Name" sortable>
                    <a :href="'?page=widgetizer&widget_provider=' + props.row.widget_provider + '&widget_name=' + props.row.widget_name">{{ props.row.widget_provider }}/{{ props.row.widget_name }}</a>
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
                columns: [
                    {
                        field: 'widget_name',
                        label: 'Widget Name',
                    },
                    {
                        field: 'widget_icon',
                        label: 'Icon'
                    },
                    {
                        field: 'widget_path',
                        label: 'Widget Path',
                    }
                ],
                errors: []
            }
        },
        created() {
            window.axios
                .get('/wp-json/widgetizer/v1/widgets/')
                .then(
                    response => {
                        this.widgets = response.data;
                        console.log(this.widgets);
                    }
                )
                .catch(
                    e => { this.errors.push(e) }
                )
        }
    }
</script>
