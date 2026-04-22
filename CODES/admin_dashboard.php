<?php
/**
 * Admin Dashboard
 * Manage chatbot questions and answers
 */

require_once 'admin_auth.php';
require_once 'db.php';

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action === 'add') {
        // Add new Q&A
        $question = isset($_POST['question']) ? trim($_POST['question']) : '';
        $answer = isset($_POST['answer']) ? trim($_POST['answer']) : '';
        $keywords = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
        
        if (!empty($question) && !empty($answer)) {
            $question = $db->escape($question);
            $answer = $db->escape($answer);
            $keywords = $db->escape($keywords);
            
            $query = "INSERT INTO chatbot_qa (question, answer, keywords) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $question, $answer, $keywords);
            
            if ($stmt->execute()) {
                $message = 'Question and answer added successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error adding question: ' . $stmt->error;
                $messageType = 'error';
            }
            $stmt->close();
        } else {
            $message = 'Please fill in both question and answer fields.';
            $messageType = 'error';
        }
    } elseif ($action === 'edit') {
        // Edit existing Q&A
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $question = isset($_POST['question']) ? trim($_POST['question']) : '';
        $answer = isset($_POST['answer']) ? trim($_POST['answer']) : '';
        $keywords = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
        
        if ($id > 0 && !empty($question) && !empty($answer)) {
            $question = $db->escape($question);
            $answer = $db->escape($answer);
            $keywords = $db->escape($keywords);
            
            $query = "UPDATE chatbot_qa SET question = ?, answer = ?, keywords = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $question, $answer, $keywords, $id);
            
            if ($stmt->execute()) {
                $message = 'Question and answer updated successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error updating question: ' . $stmt->error;
                $messageType = 'error';
            }
            $stmt->close();
        } else {
            $message = 'Invalid data provided.';
            $messageType = 'error';
        }
    } elseif ($action === 'delete') {
        // Delete Q&A
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        
        if ($id > 0) {
            $query = "DELETE FROM chatbot_qa WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                $message = 'Question and answer deleted successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error deleting question: ' . $stmt->error;
                $messageType = 'error';
            }
            $stmt->close();
        }
    }
}

// Get all Q&A pairs
$query = "SELECT id, question, answer, keywords, created_at FROM chatbot_qa ORDER BY id DESC";
$result = $conn->query($query);

// Get statistics
$statsQuery = "SELECT 
    (SELECT COUNT(*) FROM chatbot_qa) as total_qa,
    (SELECT COUNT(*) FROM chat_logs) as total_chats,
    (SELECT COUNT(*) FROM chat_logs WHERE matched_question_id IS NULL) as unmatched_chats";
$statsResult = $conn->query($statsQuery);
$stats = $statsResult->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Chatbot System</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>🛠️ Admin Dashboard</h1>
            <div class="header-actions">
                <span class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</span>
                <a href="index.php" class="btn btn-secondary" target="_blank">View Chatbot</a>
                <a href="admin_logout.php" class="btn btn-danger">Logout</a>
            </div>
        </header>
        
        <?php if ($message): ?>
            <div class="message message-<?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_qa']; ?></div>
                <div class="stat-label">Total Q&A Pairs</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_chats']; ?></div>
                <div class="stat-label">Total Chats</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['unmatched_chats']; ?></div>
                <div class="stat-label">Unmatched Questions</div>
            </div>
        </div>
  
        <div class="dashboard-content">
            <div class="card">
                <h2>Add New Question & Answer</h2>
                <form method="POST" class="qa-form">
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label for="question">Question *</label>
                        <textarea id="question" name="question" rows="2" required placeholder="e.g., How do I restart my computer?"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="answer">Answer *</label>
                        <textarea id="answer" name="answer" rows="4" required placeholder="Provide a detailed answer..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="keywords">Keywords (comma-separated, optional)</label>
                        <input type="text" id="keywords" name="keywords" placeholder="e.g., restart, reboot, computer">
                        <small>Keywords help improve matching accuracy</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Q&A</button>
                </form>
            </div>
            
            <div class="card">
                <h2>Manage Questions & Answers</h2>
                <div class="qa-list">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="qa-item" data-id="<?php echo $row['id']; ?>">
                                <div class="qa-content">
                                    <div class="qa-question">
                                        <strong>Q:</strong> <?php echo htmlspecialchars($row['question']); ?>
                                    </div>
                                    <div class="qa-answer">
                                        <strong>A:</strong> <?php echo htmlspecialchars($row['answer']); ?>
                                    </div>
                                    <?php if (!empty($row['keywords'])): ?>
                                        <div class="qa-keywords">
                                            <strong>Keywords:</strong> <?php echo htmlspecialchars($row['keywords']); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="qa-meta">
                                        Created: <?php echo date('M d, Y H:i', strtotime($row['created_at'])); ?>
                                    </div>
                                </div>
                                <div class="qa-actions">
                                    <button class="btn btn-small btn-edit" onclick="editQA(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this Q&A?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-small btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="no-data">No questions and answers found. Add your first Q&A pair above.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Question & Answer</h2>
            <form method="POST" class="qa-form">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit-id">
                <div class="form-group">
                    <label for="edit-question">Question *</label>
                    <textarea id="edit-question" name="question" rows="2" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-answer">Answer *</label>
                    <textarea id="edit-answer" name="answer" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-keywords">Keywords (comma-separated, optional)</label>
                    <input type="text" id="edit-keywords" name="keywords">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Q&A</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function editQA(qa) {
            document.getElementById('edit-id').value = qa.id;
            document.getElementById('edit-question').value = qa.question;
            document.getElementById('edit-answer').value = qa.answer;
            document.getElementById('edit-keywords').value = qa.keywords || '';
            document.getElementById('editModal').style.display = 'block';
        }
        
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }
        
        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.message');
            messages.forEach(function(msg) {
                msg.style.opacity = '0';
                setTimeout(function() {
                    msg.style.display = 'none';
                }, 300);
            });
        }, 5000);
    </script>
</body>
</html>






