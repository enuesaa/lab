const std = @import("std");

pub fn main() !void {
    const allocator = std.heap.page_allocator;

    // zsh を立ち上げる
    const argv = &[_][]const u8{"zsh"};
    var child = std.process.Child.init(argv, allocator);

    // カレントディレクトリで
    child.cwd_dir = std.fs.cwd();

    // 環境変数をセット
    var envmap = try std.process.getEnvMap(allocator);
    try envmap.put("AAA", "bbb");
    child.env_map = &envmap;

    // 立ち上げ
    const term = try child.spawnAndWait();
    std.debug.print("exit code: {d}\n", .{term.Exited});
}
