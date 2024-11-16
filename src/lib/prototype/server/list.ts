import fs from 'node:fs/promises'

export const listPrototypeNames = async (): Promise<string[]> => {
	const files = await fs.readdir('./data', { withFileTypes: true })
	return files.map((f) => f.name)
}
