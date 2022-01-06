<template>
    <div>
        <div v-if="field.value">
            <div class="flex items-center font-bold">
                <router-link
                    :to="{ name: 'detail', params: {
                        resourceName: resourceName,
                        resourceId: safeFieldId,
                    }}"
                    :title="field.value"
                    :target="target"
                    class="no-underline dim text-primary font-bold"
                    >{{ safeFieldValue }}</router-link>
            </div>
        </div>
        <!-- <p v-else>&nbsp;</p> -->
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    computed: {
        target () {
            return this.field.newTab ? '_blank' : '_self'
        },
        safeFieldPrefix() {
            return typeof this.field.prefix !== 'undefined' ? this.field.prefix : '';
        },
        safeFieldSuffix() {
            return typeof this.field.suffix !== 'undefined' ? this.field.suffix : '';
        },
        safeFieldValue() {
            const { value } = this.field;
            const fieldPrefix = this.safeFieldPrefix;
            const fieldSuffix = this.safeFieldSuffix;

            return fieldPrefix + value + fieldSuffix;
        },
        safeFieldKey() {
            return typeof this.field.fieldKey !== 'undefined' ? this.field.fieldKey : 'id';
        },
        safeFieldId() {
            const key = this.safeFieldKey;

            return typeof this.field[key] !== 'undefined'
                ? this.field[key]
                : this.field.id;
        },
    }
}
</script>
