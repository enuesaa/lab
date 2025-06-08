type Parsed = {
	content: string
	attrs: {
		[key: string]: string
	}
}

export const parseAttrs = (text: string): Parsed => {
	const res = {
		content: '',
		attrs: {},
	} as Parsed
	if (text === '') {
		return res
	}

	const matched = text.matchAll(/(\w+)=\(([^)]+)\)/g)
	for (const [_, key, value] of matched) {
		res.attrs[key] = value
		text = text.replace(`${key}=(${value})`, '')
	}
	res.content = text.trimStart()

	return res
}
