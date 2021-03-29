export const fieldMixin = {
	methods: {
		replace() {
			if (!this.field['withLink']) return
			return fillPlaceholders(this.field['link'], this.item)
		}
	}
}