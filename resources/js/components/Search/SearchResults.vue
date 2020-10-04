<script>
import { mapState, mapGetters } from "vuex";

export default {
	props: {
		group: { type: String, required: true }
	},

	render() {
		return this.$scopedSlots.default({
			params: this.currentParams,
			total: this.currentTotal,
			records: this.currentRecords
		});
	},

	computed: {
		...mapState('search', ['params', 'records']),
		...mapGetters('search', ['total']),

		currentParams() {
			return this.params[this.group];
		},

		currentRecords() {
			return this.records[this.group] || [];
		},

		currentTotal() {
			return this.total[this.group];
		}
	}
}
</script>
