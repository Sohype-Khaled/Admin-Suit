window.fillPlaceholders = (pathPattern, values = {}) => {
	const matches = pathPattern.match(/:[a-z]+/gi)
	if (!matches) {
		return pathPattern
	}

	// Get a list of unique placeholders
	const placeholders = matches.filter((value, index, self) => self.indexOf(value) === index)

	// Sort the placeholders by length descending, so that we'll fill the longest
	// ones first (avoiding bugs like if there are :id and :idea)
	placeholders.sort((a, b) => b.length - a.length)

	// Loop through placeholders and replace them
	return placeholders.reduce((outputPath, placeholder) => {
		const value = values[placeholder.substring(1)]
		if (value == null) {
			throw new Error(`Missing value for ${placeholder}`)
		}
		return outputPath.replace(new RegExp(placeholder, 'g'), value)
	}, pathPattern)
}


window.toTitleCase = (str) => {
	return str[0].toUpperCase() + str.slice(1)
}