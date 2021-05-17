import {createApp} from 'vue'
import axios from 'axios'
import './utils'
import registerComponents from "./registerComponents";
import ListingViewApp from "./components/ListingView/ListingViewApp";
import FormPanel from "./components/Form/FormPanel";

window.$axios = axios.create({
	headers: {
		common: {
			'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
		}
	}
})


for (let ListingView of document.getElementsByClassName('listing-view')) {
	let app = createApp(ListingViewApp, {
		initialData: JSON.parse(ListingView.getAttribute('data-data'))
	})
	registerComponents(app)
	app.mount(`#${ListingView.getAttribute('id')}`)
}

for (let Form of document.getElementsByClassName('admin-suit-form-panel')) {
	let app = createApp(FormPanel, {
		data: JSON.parse(Form.getAttribute('data-data')),
		errors: JSON.parse(Form.getAttribute('data-errors'))
	})
	registerComponents(app)
	app.mount(`#${Form.getAttribute('id')}`)
}