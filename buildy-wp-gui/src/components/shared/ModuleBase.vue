<template>
    <transition name="fadeHeight">
        <div
            class="module component-module rounded text-module relative flex flex-wrap items-center text-gray-400 p-1"
            :class="[isValidComponent ? 'bg-gray-800' : 'bg-gray-600']"
            :id="component.id"
        >
            <module-settings-bar
                :parent_array="parent_array"
            ></module-settings-bar>

            <p
                ref="adminLabel"
                contenteditable="true"
                @blur="setDeep(component, 'options.admin_label', $el.innerText)"
                class="mx-auto my-0 py-2"
            >
                {{ admin_label }}
            </p>

            <component :component="component" :is="moduleType"> </component>
        </div>
    </transition>
</template>

<script>
import { setDeep } from "../../functions/objectHelpers";
import { mapGetters } from "vuex";
export default {
    name: "module-base",
    props: {
        component: Object,
        parent_array: Array
    },
    computed: {
        ...mapGetters(["validComponents"]),
        admin_label() {
            if (this.component.options && this.component.options.admin_label) {
                return this.component.options.admin_label;
            } else {
                return this.component.type
                    ? this.component.type
                    : "Placeholder for unknown component";
            }
        },
        isValidComponent() {
            return this.componentMap(this.component.type);
        },
        moduleType() {
            return this.isValidComponent ? this.component.type : "ShellModule";
        }
    },
    methods: {
        componentMap(el) {
            return !!this.validComponents.includes(el);
        },
        setDeep
    },
    provide() {
        return {
            component: this.component,
            parent_array: this.parent_array
        };
    }
};
</script>
<style>
.component-module {
    transition: all 0.2s;
}

.list-enter-active,
.list-leave-active {
    transition: all 1s;
}
.list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
    opacity: 0;
    transform: translateY(30px);
}
</style>
