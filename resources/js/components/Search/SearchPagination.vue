 <template>
	<form
		v-if="show"
		class="w-full md:w-1/3 mx-auto mt-3 grid grid-cols-5 gap-0 text-gray-700"
	>
		<span
			:class="buttonClass('first')"
			class="row-span-1 flex items-center justify-center border rounded-l-sm"
			@click="goToFirst"
		>
			<double-angle-left class="fill-current h-4 pointer-events-none" />
		</span>
		<span
			:class="buttonClass('prev')"
			class="row-span-1 flex items-center justify-center border-t border-b"
			@click="goToPrev"
		>
			<angle-left class="fill-current h-4 pointer-events-none" />
		</span>
		<span class="row-span-1 relative">
			<select
				id="per_page"
				class="appearance-none rounded-none block w-full bg-gray-200 focus:bg-white text-gray-700 border border-gray-400 focus:border-gray-500 py-3 pl-4 pr-8 leading-tight focus:outline-none"
				:class="{ 'opacity-50': !hasPages }"
				:disabled="!hasPages"
				@change="change"
			>
				<option
					v-for="page in pages"
					:key="page"
					:value="page"
					:selected="page === current"
				>{{ page }}</option>
			</select>
			<select-angle :class="{ 'opacity-50': !hasPages }"></select-angle>
		</span>
		<span
			:class="buttonClass('next')"
			class="row-span-1 flex items-center justify-center border-t border-b"
			@click="goToNext"
		>
		<angle-right class="fill-current h-4 pointer-events-none" />
		</span>
		<span
			:class="buttonClass('last')"
			class="row-span-1 flex items-center justify-center border rounded-r-sm"
			@click="goToLast"
		>
			<double-angle-right class="fill-current h-4 pointer-events-none" />
		</span>
	</form>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";

import AngleLeft from '../Icons/AngleLeft';
import DoubleAngleLeft from '../Icons/DoubleAngleLeft';
import AngleRight from '../Icons/AngleRight';
import DoubleAngleRight from '../Icons/DoubleAngleRight';
import SelectAngle from '../Form/SelectAngle';

export default {
	components: {
		AngleLeft,
		DoubleAngleLeft,
		AngleRight,
		DoubleAngleRight,
		SelectAngle
	},

	props: {
		group: { type: String, required: true },
		alwaysShow: { type: Boolean, required: false, default: false }
	},

	data() {
		return {
			defaultClass: 'px-4 py-1 inline-fiex border-solid',
			activeClass: 'cursor-pointer border-gray-400 hover:bg-gray-400 text-gray-700',
			inactibeClass: 'cursor-not-allowed opacity-50 border-gray-300 text-gray-300'
		};
	},

	created() { },

	mounted() { },

	methods: {
		...mapActions('search', ['store']),

		buttonActiveClass(isTrue) {
			return ' '+(isTrue ? this.activeClass : this.inactibeClass);
		},

		buttonClass(action) {
			let css = this.defaultClass;

			switch (action) {
				case 'first':
				case 'prev':
					css += this.buttonActiveClass(this.prev);
					break;

				case 'next':
				case 'last':
					css += this.buttonActiveClass(this.next);
					break;
			}
			return css;
		},

		goTo(page = null) {
			if (!page || page === this.current) {
				return;
			}

			this.store({
				group: this.group,
				params: {
					...this.params[this.group],
					page
				}
			});
		},

		goToFirst() {
			this.goTo(1);
		},

		goToPrev() {
			this.goTo(this.prev);
		},

		goToNext() {
			this.goTo(this.next);
		},

		goToLast() {
			this.goTo(this.last);
		},

		change(event) {
			this.goTo(event.target.value);
		}
	},

	computed: {
		...mapState('search', ['params']),
		...mapGetters('search', [
			'currentPage',
			'prevPage',
			'nextPage',
			'lastPage'
		]),

		current() {
			return this.currentPage(this.group);
		},

		prev() {
			return this.prevPage(this.group);
		},

		next() {
			return this.nextPage(this.group);
		},

		last() {
			return this.lastPage(this.group);
		},

		hasPages() {
			return this.last > 1;
		},

		pages() {
			return Array.from({ length: this.last }, (_, i) => i + 1);
		},

		show() {
			return this.hasPages || this.alwaysShow;
		}
	},

	watch: {}
};
 </script>

 <style>
</style>
