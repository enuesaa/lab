const std = @import("std");

pub fn main() !void {
    const allocator = std.heap.page_allocator;

    const argv = &[_][]const u8{"zsh"};
    var child = std.process.Child.init(argv, allocator);
    child.cwd_dir = std.fs.cwd();

    var envmap = try std.process.getEnvMap(allocator);
    try envmap.put("AAA", "bbb");
    child.env_map = &envmap;

    const exit_code = try child.spawnAndWait();
    std.debug.print("Exit code: {}\n", .{exit_code});
}
