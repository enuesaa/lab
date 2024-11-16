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
	description: string
	image: string
	open: string // deprecated
	filetree: UnitFiletree
	output: string
}

export type UnitFiletree = {
	open: string
	ignore: string[]
}
