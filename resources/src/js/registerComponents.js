import DefaultInput from "./components/Form/DefaultInput";
import Input from "./components/Form/Input";
import PlainInput from "./components/Form/PlainInput";
import TextareaInput from "./components/Form/TextareaInput";
import SlugInput from "./components/Form/SlugInput";
import Multiselect from '@vueform/multiselect'
import SelectInput from "./components/Form/SelectInput";
import BelongsToInput from "./components/Form/BelongsToInput";
import BelongsToManyInput from "./components/Form/BelongsToManyInput";

export default function (app) {


	app.component('VInput', Input)

	app.component('VTextField', DefaultInput)

	app.component('VNumberField', DefaultInput)

	app.component('VDateTimeField', DefaultInput)

	app.component('VFileField', DefaultInput)

	app.component('VBooleanField', PlainInput)

	app.component('VTextareaField', TextareaInput)

	app.component('VSlugField', SlugInput)

	app.component('Multiselect', Multiselect)

	app.component('VSelectField', SelectInput)

	app.component('VBelongsToField', BelongsToInput)

	app.component('VBelongsToManyField', BelongsToManyInput)

}