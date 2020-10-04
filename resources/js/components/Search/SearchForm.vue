<script>
import { debounce } from "lodash";
import { mapActions, mapActions0 } from "vuex";

export default {
	props: {
		group: { type: String, required: true },
		url: { type: String, required: true },
		method: { type: String, required: false, default: 'get' },
		params: { type: Object, required: true },
	},

	data() {
		return {
			fields: { ...this.params },
			processing: false
		};
	},

	created() {
		this.init({
			group: this.group,
			url: this.url,
			method: this.method,
			params: this.fields
		}).then(params => {
			this.fields = params;
		});
	},

	render() {
		return this.$scopedSlots.default({
			params: this.fields,
			update: this.update,
			change: this.change,
			clear: this.clear,
			processing: this.processing
		});
	},

	methods: {
		...mapActions('search', ['init', 'store', 'reset']),

		update: debounce(function() {
			this.change();
		}, 1000),

		change() {
			this.processing = true;
			this.store({
				group: this.group,
				params: this.fields
			}).then(() => (this.processing = false));
		},

		clear(fields) {
			this.reset({
				group: this.group,
				params: { ...this.fields, ...fields }
			}).then(value => {
				this.fields = value;
			});
		}
	}
}
</script>
