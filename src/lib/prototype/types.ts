export type Config = {
	title: string
	description: string
	published: string
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

export type Project = Config & {
	name: string
}

export type TreeData = {
	id: string
	title: string
	children: TreeData[]
	code: string
	language: string
}
export type UnitWithTreeData = Unit & { files: TreeData[] }
