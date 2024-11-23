import fs from 'node:fs/promises'
import path from 'node:path'
import type { TreeData } from '../tree'
import type { Project, UnitFiles } from '../types'

export const getUnitFiles = async (project: Project): Promise<UnitFiles> => {
	const unitfiles: UnitFiles = {}

	for (const unit of project.units) {
		if (unit.open === undefined) {
			continue
		}
		const include = unit.include ?? []
		include.push(unit.open) // by default
		unitfiles[unit.title] = await extract(`./data/${project.name}`, '', include)
	}

	return unitfiles
}

const extract = async (dir: string, baseDir: string = '', include: string[]): Promise<TreeData[]> => {
	const data: TreeData[] = []
	const files = await fs.readdir(dir, { withFileTypes: true })

	for (const file of files) {
		const filepath = path.join(dir, file.name)
		const relpath = path.join(baseDir, file.name)

		if (!include.includes(relpath)) {
			continue
		}

		if (file.isDirectory()) {
			const children = await extract(filepath, relpath, include)
			data.push({
				id: relpath,
				title: file.name,
				isDir: true,
				children,
				code: '',
				language: '',
			})
		} else {
			const language = file.name.split('.').at(-1) ?? ''
			const code = await fs.readFile(filepath, 'utf8')
			data.push({
				id: relpath,
				title: file.name,
				isDir: false,
				children: [],
				code,
				language,
			})
		}
	}
	return data
}
