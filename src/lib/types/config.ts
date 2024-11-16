export type Config = {
	title: string
	description: string
	published: string
	ignore: string[]
	units: Unit[]
}

export type Unit = {
	name: string
	title: string
	open: string
	output: string
}
