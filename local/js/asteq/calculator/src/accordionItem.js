import {Vue} from 'ui.vue';

const Accordionitem = Vue.component('Accordionitem', {
    name: 'Accordionitem',
    template: `
		<div 
			class="as-accordion__item" 
			:class="{ 'as-accordion__item_active': visible, 'as-accordion__item_disabled': !clickable }"
		>
			<div 
			  class="as-accordion__item-trigger"
			  :class="{ 'as-accordion__item-trigger_active': visible }"
			>
			  <div class="as-accordion__item-title-with-btn">  
			    <div class="as-accordion__item-title"  @click="setActiveItem">{{ title }}</div>
			  </div>
			  <div class="as-accordion__item-icon" :class="{ 'as-accordion__item-icon_active': visible }">
				<svg width="21" height="22" viewBox="0 0 129 129" fill="none" xmlns="http://www.w3.org/2000/svg">
				  <g opacity="1">
					<path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" fill="#003a7d"/>
				  </g>
				</svg>
			  </div>
			</div>
			<transition 
			  name="as-accordion" 
			  @enter="start" 
			  @after-enter="end" 
			  @before-leave="start" 
			  @after-leave="end"
			>
			  <div class="as-accordion__item-wrapper" v-show="visible">
				<div class="as-accordion__item-content">
				<slot></slot>
                </div>
			  </div>
			</transition>
			<div class="as-accordion__item-btn-next button--primary" :class="{'disabled': isDisabled}" v-if="visible && showNext" @click="goNext">
                 <span class="button__text">Далее</span>
              </div>
		  </div>
	`,
    data() {
        return {
            visible: false,
        }
    },
    props: {
        title: {
            type: String,
            default() {
                return ''
            }
        },
        clickable: {
            type: Boolean,
            default() {
                return false
            }
        },
        showNext: {
            type: Boolean,
            default() {
                return true
            }
        },
        isVisible: {
            type: Boolean,
            default() {
                return false
            }
        },
        internalName: {
            type: String,
            default() {
                return 'item'
            }
        },
        isDisabled: {
            type: Boolean,
            default() {
                return false
            }
        }
    },
    mounted() {
        this.visible = this.isVisible;
    },
    watch: {
        isVisible(newVal, oldVal) {
            this.visible = newVal;
        }
    },
    methods: {
        setActiveItem() {
            if (this.clickable) {
                this.visible = true;
                if (this.visible) {
                    this.$emit('select-part', {name: this.internalName});
                }
            }
        },
        goNext() {
            if (this.clickable) {
                //this.visible = false;
                this.$emit('go-next', {name: this.internalName});
            }
        },
        start(el) {
            el.style.height = `${el.scrollHeight}px`;
        },
        end(el) {
            el.style.height = '';
        },
    }
});

export default Accordionitem;